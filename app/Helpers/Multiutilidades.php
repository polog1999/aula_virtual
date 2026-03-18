<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


// --- FUNCIÓN 1: OBTENER ACCESS TOKEN (securitykey) ---
function getAccessToken($numorden, $environment)
{
    // Cargar configuraciones de Laravel .env
    if ($environment === 'prd') {
        $url = env('SECURITY_URL_PROD');
        $accessKey = env('USER_PROD');
        $secretKey = env('PASSWORD_PROD');
    } else {
        
        $url = env('SECURITY_URL_DEV');
        $accessKey = env('USER_DEV');
        $secretKey = env('PASSWORD_DEV');
    }

    Log::info("{$numorden} - Request securitykey URL: {$url}");

    $header = array("Content-Type: application/json");
    $authString = "{$accessKey}:{$secretKey}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, $authString);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // CORRECCIÓN
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $key = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200 || $http_code === 201) {

        // Si el cuerpo es JSON (como a veces ocurre), decodificar
        $data = json_decode($key, true);

        // Si es 201 o 200 y no tiene formato JSON, el token es el cuerpo ($response)
        $accessToken = $data['access_token'] ?? $key;
        $accessToken = trim($accessToken);
        $accessToken = str_replace(array('\\', "\n", "\r", "\t", ' '), '', $accessToken);

        // Reemplazamos el log de error por info
        Log::info("{$numorden} - Response securitykey SUCCESS ({$http_code}): Token obtenido.");

        // Aquí implementas la lógica de guardar en sesión/caché antes de retornar
        // ... [Tu código para Session::put($sessionKey, ...)] ...

        return $accessToken;
    } else {
        // Solo registrar como error si el código es realmente de fallo (4xx, 5xx)
        Log::error("{$numorden} - Response securitykey REAL ERROR ({$http_code}): {$key}");
        return null;
    }

    return $key;
}


// --- FUNCIÓN 2: OBTENER SESSION KEY (create_token) ---
function getSessionKey($merchantId, $environment, $amount, $accessToken, $numorden, $buyerData)
{
    if ($environment === 'prd') {
        $url = env('SESSION_URL_PROD') . $merchantId;
    } else {
        $url = env('SESSION_URL_DEV') . $merchantId;
    }

    $header = array("Content-Type: application/json", "Authorization: {$accessToken}");

    // Desestructurar datos de la orden
    $cdgo_id = $buyerData['seccion_id'] ?? '';
    $cdgo_usrios = $buyerData['user_id'] ?? '';
    $de_mail = $buyerData['email'] ?? '';
    $nu_tele = $buyerData['phone'] ?? '';
    $de_dcmntos_iden = $buyerData['doc_type'] ?? 'DNI';
    $nu_docu = $buyerData['doc_number'] ?? '';

    $request_body = json_encode([
        "amount" => (float) $amount,
        "channel" => "web",
        "antifraud" => [
            "clientIp" => Request::ip(),
            "merchantDefineData" => [
                "MDD4" => $de_mail,
                "MDD21" => "0",
                "MDD30" => $cdgo_id,
                "MDD31" => $nu_tele,
                "MDD32" => $cdgo_usrios,
                "MDD33" => $de_dcmntos_iden,
                "MDD34" => $nu_docu,
                "MDD37" => "0",
                "MDD63" => $de_dcmntos_iden,
                "MDD65" => $nu_docu
            ]
        ]
    ]);

    Log::info("{$numorden} - Request create_token: {$request_body}");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);
    $sessionKey = $json['sessionKey'] ?? null;


    if ($http_code === 200) {
        Log::info("{$numorden} - Response create_token: {$response}");
    } else {
        Log::error("{$numorden} - Response create_token ERROR ({$http_code}): {$response}");
    }

    return $sessionKey;
}


// ... (Otras funciones y definiciones de tu helper, como la de seguridad y sesión)

function authorization(
    $merchantId,
    $environment,
    $accessToken,
    $amount,
    $transactionToken,
    $purchaseNumber,
    $log_path // Necesitas la ruta base para el log
) {
    // 1. Configuración de URL según el entorno
    switch ($environment) {
        case 'prd':
            $url = "https://apiprod.vnforapps.com/api.authorization/v3/authorization/ecommerce/" . $merchantId;
            break;
        case 'dev':
            // Asegúrate de usar el Merchant ID de Sandbox aquí
            $url = "https://apisandbox.vnforappstest.com/api.authorization/v3/authorization/ecommerce/" . $merchantId;
            break;
        default:
            // Manejar un entorno no válido
            return 500;
    }

    // 2. Encabezados HTTP
    // IMPORTANTE: Asegúrate de que el token lleva el prefijo 'Bearer ' si es necesario
    $cleanToken = trim($accessToken);
    $cleanToken = str_replace(array('\\', "\n", "\r", "\t", ' '), '', $cleanToken);

    $header = array(
        "Content-Type: application/json",
        "Authorization: " . $cleanToken
    );

    // 3. Cuerpo de la Solicitud (JSON)
    // NOTA IMPORTANTE: El monto NO debe ir entre comillas si es un valor numérico
    // que requiere decimales (ej. 100.00), pero Niubiz a veces acepta cadena.
    // Lo corregimos a la forma recomendada: sin comillas.
    $request_body = json_encode([
        "antifraud" => null,
        "captureType" => "manual", // O "automatic" si deseas captura inmediata
        "channel" => "web",
        "countable" => false, // Cambiar a true si el pago debe contarse en reportes
        "order" => [
            // Asegúrate que $amount no es una cadena JSON
            "amount" => floatval($amount),
            "tokenId" => $transactionToken,
            "purchaseNumber" => $purchaseNumber,
            "currency" => "PEN"
        ]
    ]);

    // 4. Logging de la Solicitud (adaptado a tu formato)
    $a = $purchaseNumber . "-request authorization: " . $request_body . "\n";


    if (!file_exists($log_path)) {
        // El 'true' es para que cree directorios anidados (recursivo)
        // El '0777' son los permisos (puede variar según el entorno)
        mkdir($log_path, 0777, true);
    }
    $destino = $log_path . "/ver.log"; // Usa la ruta base que definas
    $abrirdes = fopen($destino, "a");
    if ($abrirdes) {
        @fputs($abrirdes, $a);
        fclose($abrirdes);
    }

    // 5. Ejecución cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // Usar en DEV, NO en PRD
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $respuesta = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // 6. Procesamiento y Logging de la Respuesta
    $leer_respuesta = json_decode($respuesta, true);
    $json_pretty = json_encode($leer_respuesta, JSON_PRETTY_PRINT);

    $a = $purchaseNumber . "-Response authorization: " . $status . "|" . $json_pretty . "\n";
    $abrirdes = fopen($destino, "a");
    if ($abrirdes) {
        @fputs($abrirdes, $a);
        fclose($abrirdes);
    }

    // 7. Mapeo de la Respuesta a la Base de Datos (clase_mantenimiento)
    if ($status == 200) {
        // Lógica de éxito (CÓDIGO DE TU CÓDIGO ORIGINAL)
        // ...
        // $mante = new clase_mantenimiento();
        // Asignar los valores de $leer_respuesta['order'] y $leer_respuesta['dataMap']
        // ...
        //$mante->alma_frma_pgo(__FILE__."-".__LINE__);
        // ...
    } else if ($status == 400) {
        // Lógica de error (CÓDIGO DE TU CÓDIGO ORIGINAL)
        // ...
        // $mante = new clase_mantenimiento();
        // Asignar los valores de $leer_respuesta['data']
        // ...
        //$mante->alma_frma_pgo(__FILE__."-".__LINE__);
        // ...
    }

    return [
        'respuesta' => $leer_respuesta,
        'status' => $status
    ];
}
