<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscripcionRequest;
use App\Mail\ComprobantePagoMail;
use App\Mail\ConfirmaciónPagoMail;
use App\Mail\VerificacionCodigoMail;
use App\Models\Categoria;
use App\Models\CronogramaPago;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\EmailVerification;
use App\Models\Horario;
use App\Models\Inscripcion;
use App\Models\InscripcionAlumno;
use App\Models\InscripcionApoderado;
use App\Models\Lugar;
use App\Models\Matricula;
use App\Models\oracle\Contribuyente;
use App\Models\oracle\Distrito;
use App\Models\oracle\ServiciosTusne;
use App\Models\Orden;
use App\Models\OrdenAlumno;
use App\Models\OrdenApoderado;
use App\Models\Pago;
use App\Models\PagosNiubiz;
use App\Models\PreInscripcion;
use App\Models\Seccion;
use App\Models\Taller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SoapClient;
use SoapFault;

class TallerController extends Controller
{
    public function show(Curso $disciplina)
    {
        // echo json_decode($this->ws_reniec('70829156')->getContent(), true);
        // echo $this->ws_reniec('JS', '70829156')['direccion'];
        // $distritos = Distrito::select('districodi', 'distridesc')->get();

        // dd($distritos->toArray());
        $esAdulto = false;
        $categorias = Categoria::select(['id', 'nombre'])->get();

        // $sedes = Lugar::select('id', 'nombre')
        //     ->whereHas('secciones.talleres', function ($q) use ($disciplina) {
        //         $q->where('disciplina_id', $disciplina->id);
        //     })
        //     ->get();

        $secciones = Seccion::select('secciones.*')->with(['curso', 'docentes.user', 'lugares', 'horarios'])
            ->withCount([
                'matriculas as matriculas_activas_count' => function ($q) {
                    $q->where('estado', 'ACTIVA');
                }
            ])
            ->join('cursos', 'secciones.curso_id', '=', 'cursos.id')
            ->where('secciones.activo', true)
            ->whereHas('curso', function ($q) use ($disciplina) {
                $q->where('curso_id', $disciplina->id);
            })
            ->orderBy('cursos.nombre', 'asc')
            ->get();

        $secciones->map(function ($seccion) {
            // $edadMin = $seccion->talleres->categoria->edad_min ?? 0;
            // $edadMax = $seccion->talleres->categoria->edad_max ?? 0;
            // $tiene_discapacidad =  $seccion->talleres->categoria->tiene_discapacidad;
            // $edadMin = null;
            // $edadMax = null;
            // $tiene_discapacidad = true;

            // if ($edadMax == null) {
            //     $edadMax = 0;
            // }
            // if (($edadMin == null && $edadMax == null) && !$tiene_discapacidad) {
            //     $seccion->es_adulto = 'todos';
            // } else if (($edadMin >= 18 || $edadMax >= 18) && !$tiene_discapacidad) {
            //     $seccion->es_adulto = 'si';
            // } else if ($tiene_discapacidad && ($edadMin == null && $edadMax == null)) {
            //     $seccion->es_adulto = 'discapacitado';
            // } else {
            //     $seccion->es_adulto = 'no';
            // }


            // dd($seccion->es_adulto);
            return $seccion;
        });


        return view('talleres', compact('categorias', 'secciones', 'disciplina'
        // , 'distritos'
        ));
    }


    public function storeInscripcion(InscripcionRequest $request)
    {
        // $validateData = $request->validate([
        //     'idTaller' => ['required', Rule::exists('secciones','id')->where(function($q){
        //         $q->where('activo',true);
        //     })],
        //     'inscriptionType' => ['required', 'string','in:minor,adult'],
        //     'parentDNI' => ['required', 'digits:8', Rule::requiderIf($request->inscriptionType == 'minor')],
        //     'studentDNI' => ['required', 'digits:8', Rule::requiderIf($request->inscriptionType == 'minor' || $request->inscriptionType == 'adult') ],
        //     'idCategoria' => ['required', 'exists:categorias,id'],
        //     'studentBirthdate' => ['required', 'date', Rule::requiderIf($request->inscriptionType == 'minor' || $request->inscriptionType == 'adult')],

        // ]);


        $inscripcion = Inscripcion::where('seccion_id', $request->idTaller)
            ->where(function ($query) use ($request) {
                if ($request->inscriptionType === 'minor') {

                    $query->WhereHas('ordenApoderado', function ($q2) use ($request) {
                        $q2->where('numero_documento', $request->parentDNI);
                    })
                        ->whereHas('ordenAlumno', function ($q2) use ($request) {
                            $q2->where('numero_documento', $request->studentDNI);
                        });
                } else {
                    $query->whereHas('ordenAlumno', function ($q1) use ($request) {
                        $q1->where('numero_documento', $request->studentDNI);
                    });
                }
            })
            ->where('estado', 'PAGADO')->exists();

        if ($inscripcion) {
            return back()->with('info', 'Este taller, ya fue pagado');
        }
        $requestEmail = null;
        if ($request->inscriptionType === 'minor') {
            $requestEmail = $request->parentEmail;
            $codigoVerificacion = $request->parent_verification_code;
            $esUsuario = User::where('tipo_documento', 'DNI')->where('numero_documento', $request->parentDNI)->exists();
            $email = User::where('tipo_documento', 'DNI')->where('numero_documento', $request->parentDNI)->value('email');
        } else {
            $requestEmail = $request->studentEmail;
            $codigoVerificacion = $request->student_verification_code;
            $esUsuario = User::where('tipo_documento', 'DNI')->where('numero_documento', $request->studentDNI)->exists();
            $email = User::where('tipo_documento', 'DNI')->where('numero_documento', $request->studentDNI)->value('email');
        }


        if ($esUsuario && $requestEmail != $email) {
            return back()->with('info', 'Ya estas registrado con el email: ' . $email);
        }
        $codigoValido = EmailVerification::where('email', $requestEmail)->where('code', $codigoVerificacion)->where('expires_at', '>', now())->exists();
        if (!$codigoValido) {
            return back()->with('error', 'Codigo Verificación Incorrecto');
        }
        // dd('funcion');
        $cumpleCategoria = false;
        $categoria = Categoria::findOrFail($request->idCategoria);
        $edadMax = $categoria->edad_max;
        $edadMin = $categoria->edad_min;

        $edad = Carbon::parse($request->studentBirthdate)->age;
        if ($edad >= $edadMin && $edad <= $edadMax) {
            $cumpleCategoria =  true;
        } else if ($edad >= $edadMin && $edadMax == null) {
            $cumpleCategoria =  true;
        } else if ($edadMin == null && $edadMax == null) { /// falta hacer logica para validar la edad al inscribirse
            $cumpleCategoria =  true;
        } else {
            $cumpleCategoria = false;
        }
        // $tipoInscripcion =  $request->inscriptionType;
        // $esDocente = User::where('numero_documento', $tipoInscripcion == 'minor' ? $request->parentDNI : $request->studentDNI)->where('role', 'DOCENTE')->exists();
        // if($esDocente){
        //     return back()->with('warning', "No se puede inscribir");
        // }
        if ($cumpleCategoria) {

            $usuario = User::where('numero_documento', $request->studentDNI)->has('alumno')->first();
            if ($usuario) {
                $alumno = $usuario->alumno;
                $seccionesId = $alumno->matricula()->where('estado', 'ACTIVA')->pluck('seccion_id');
                $seccionesExistentes = Seccion::with('horarios', 'talleres.disciplina')->whereIn('id', $seccionesId)->get();
                $horarioNuevo = Horario::where('seccion_id', $request->idTaller)->get();

                foreach ($seccionesExistentes as $seccion) {
                    // dd($seccion);
                    foreach ($seccion->horarios as $horarioExistente) {
                        foreach ($horarioNuevo as $nuevo) {
                            if ($horarioExistente->dia_semana == $nuevo->dia_semana) {
                                $cruce = ($nuevo->hora_inicio < $horarioExistente->hora_fin) && ($nuevo->hora_fin > $horarioExistente->hora_inicio);
                                if ($cruce) {
                                    $nombreTaller = $seccion->talleres->disciplina->nombre;

                                    return back()->with('warning', "Cruce de horario el día $nuevo->dia_semana con el taller de $nombreTaller ($seccion->nombre) (" . Carbon::parse($horarioExistente->hora_inicio)->format('g:i a') . " - " . Carbon::parse($horarioExistente->hora_fin)->format('g:i a') . ")");
                                }
                            }
                        }
                    }
                }
            }

            // $seccionId = $request->seccion_id;
            // $merchantId = env('MERCHANT_ID_DEV');
            // $monto = $request->costoMensualidad;
            $datosApoderado = [];
            $datosAlumno = [];
            $ordenApoderadoId = null;

            $esVecino = null;

            if ($request->inscriptionType === 'minor') {
                // $codigoDistrito =$request->parentDistrito ?? $request->parentDistritoId; 
                $distrito = Distrito::where('districodi', $request->parentDistrito)->value('distridesc');
                if (trim($request->parentDistrito) == '12') {
                    $esVecino = true;
                } else {
                    $esVecino = false;
                }
                if ($distrito == null) {
                    $distrito = 'DISTRITO FUERA DE LIMA';
                }
                $datosAlumno = [
                    'nombres' => $request->studentNames,
                    'apellido_paterno' => $request->studentPaternalLastName,
                    'apellido_materno' => $request->studentMaternalLastName,
                    'fecha_nacimiento' => $request->studentBirthdate,
                    'tipo_documento' => 'DNI',
                    'numero_documento' => $request->studentDNI,
                    'numero_conadis' => $request->conadis_number

                ];

                $datosApoderado = [
                    'nombres' => $request->parentNames,
                    'apellido_paterno' => $request->parentPaternalLastName,
                    'apellido_materno' => $request->parentMaternalLastName,
                    'direccion' => $request->parentDireccion,
                    'distrito' => trim($distrito),
                    'codigo_distrito' => $request->parentDistrito,
                    'celular' => $request->parentPhone,
                    'tipo_documento' => 'DNI',
                    'numero_documento' => $request->parentDNI,
                    'email' => $request->parentEmail,

                ];
                try {
                    $orden_apoderado = InscripcionApoderado::firstOrCreate(
                        [
                            'tipo_documento' => 'DNI',
                            'numero_documento' => $request->parentDNI
                        ],
                        $datosApoderado
                    );
                } catch (QueryException $e) {
                    if ($e->getCode() === '23505') {
                        return redirect()
                            ->back()
                            ->with('error', 'Este email ya esta siendo utilizado');
                    }
                }
                $ordenApoderadoId = $orden_apoderado->id;
            } else {
                $distrito = Distrito::where('districodi', $request->studentDistrito)->value('distridesc');
                if (trim($request->studentDistrito) == '12') {
                    $esVecino = true;
                } else {
                    $esVecino = false;
                }
                if ($distrito == null) {
                    $distrito = 'DISTRITO FUERA DE LIMA';
                }
                $datosAlumno = [
                    'tipo_documento' => 'DNI',
                    'numero_documento' => $request->studentDNI,
                    'nombres' => $request->studentNames,
                    'apellido_paterno' => $request->studentPaternalLastName,
                    'apellido_materno' => $request->studentMaternalLastName,
                    'fecha_nacimiento' => $request->studentBirthdate,
                    'email' => $request->studentEmail,
                    'direccion' => $request->studentDireccion,
                    'distrito' => trim($distrito),
                    'codigo_distrito' => $request->studentDistrito,
                    'celular' => $request->studentPhone,
                    'numero_conadis' => $request->conadis_number
                ];
            }

            try {
                $orden_alumno = InscripcionAlumno::firstOrCreate(
                    [
                        'tipo_documento' => 'DNI',
                        'numero_documento' => $request->studentDNI
                    ],
                    $datosAlumno
                );
            } catch (QueryException $e) {
                if ($e->getCode() === '23505') {
                    return redirect()
                        ->back()
                        ->with('error', 'Este email ya esta siendo utilizado');
                } else {
                    return $e->getMessage();
                }
            }


            $orden = Inscripcion::firstOrCreate(
                [
                    'seccion_id' => $request->idTaller,
                    'inscripcion_apoderado_id' => $ordenApoderadoId,
                    'inscripcion_alumno_id' => $orden_alumno->id
                ],
                [
                    'monto' => '0',
                    'reference_uuid' => (string) Str::uuid(),
                    'tipo_inscripcion' => $request->inscriptionType,
                    'es_vecino' => $esVecino
                ]
            );


            // $numeroOrden = str_pad($orden->id, 8, '0', STR_PAD_LEFT);
            // $numeroOrden = time();
            $inscripcion = $orden;
            $tusne = $inscripcion->seccion->talleres->tusnes()->where('es_vecino', $inscripcion->es_vecino)->first();
            $monto = ServiciosTusne::where('congrupo', $tusne->grupo)->where('concodigo', $tusne->codigo)->value('conmonto');
            $inscripcion->monto = $monto;
            $inscripcion->es_vecino = $esVecino;
            $inscripcion->save();
            if ($inscripcion->tipo_inscripcion == 'minor') {
                $orden_apoderado->distrito = trim($distrito);
                $orden_apoderado->codigo_distrito = trim($request->parentDistrito);
                $orden_apoderado->save();
            } else {
                $orden_alumno->distrito = trim($distrito);
                $orden_alumno->codigo_distrito = trim($request->studentDistrito);
                $orden_alumno->save();
            }
            $numeroContribuyente = null;
            if ($inscripcion->wasRecentlyCreated) {
                $inscripcion->estado = 'PENDIENTE';
                $inscripcion->numero_orden = time();
                $inscripcion->save();

                $numeroContribuyente = $this->buscarCrearContribuyente($request, $inscripcion);
            } else {
                $numeroContribuyente = $inscripcion->typeInscription == 'minor' ? $inscripcion->ordenApoderado->numero_contribuyente : $inscripcion->ordenAlumno->numero_contribuyente;
                if (!$numeroContribuyente) {
                    $numeroContribuyente = $this->buscarCrearContribuyente($request, $inscripcion);
                }
            }

            if ($numeroContribuyente) {
                if (!$inscripcion->numero_liquidacion) {
                    $tusne = $inscripcion->seccion->talleres->tusnes()->where('es_vecino', $inscripcion->es_vecino)->first();
                    $grupo = $tusne->grupo;
                    $codigo = $tusne->codigo;
                    if ($tusne) {
                        DB::connection('oracle')->statement("ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'");
                        $respuesta = DB::connection('oracle')->select(
                            "select ds_valores.fu_digito_generar('1312',?,?,?,'TEST') AS liquidacion FROM DUAL",
                            [
                                (string) trim($grupo),
                                (string) trim($codigo),
                                (string) trim($numeroContribuyente)
                            ]
                        );
                    }
                    if (!empty($respuesta)) {
                        $numeroLiquidacion = $respuesta[0]->liquidacion;
                        $inscripcion->numero_liquidacion = $numeroLiquidacion;
                        $inscripcion->save();
                    }
                }
            }

            session()->forget('terminos_aceptados');
            return redirect()->route('talleres.casi-listo', ['token' => $inscripcion->reference_uuid]);
            // ->with([
            //     'sessionToken' => $sessionToken
            //     ]
            // );
        } else {
            return back()->with(['error' => "No cumples con la categoría de edad."]);
        }
    }
    public function buscarCrearContribuyente($request, $inscripcion)
    {
        if ($request->inscriptionType == 'minor') {
            $apellidoPaterno = $request->parentPaternalLastName;
            $apellidoMaterno = $request->parentMaternalLastName;
            $nombres = $request->parentNames;
            $dni = $request->parentDNI;
            $celular = $request->parentPhone;
            $distrito = $request->parentDistrito;
            $email = $request->parentEmail;
        } else if ($request->inscriptionType == 'adult') {
            $apellidoPaterno = $request->studentPaternalLastName;
            $apellidoMaterno = $request->studentMaternalLastName;
            $nombres = $request->studentNames;
            $dni = $request->studentDNI;
            $celular = $request->studentPhone;
            $distrito = $request->studentDistrito;
            $email = $request->studentEmail;
        }


        $numeroContribuyente = Contribuyente::where('mcndni', $dni)->value('mcncontrib');

        if (!$numeroContribuyente) {

            $numeroContribuyente = $this->generarSiguienteCorrelativo();
            //==============================CREAR CONTRIBUYENTE==============================
            $contribuyente = DB::connection('oracle')->insert(
                "INSERT INTO SMACARNOM
         (MCNCONTRIB
          , MCNESTADO
          , MCNTIPO
          , MCNAPEPAT
          , MCNAPEMAT
          , MCNNOMBRE
          , MCNVIAS
          , MCNDIRE
          , MCNNUME
          , MCNDPTO
          , MCNCODURBA
          , MCNURBA
          , MCNMANZ
          , MCNLOTE
          , MCNAPENOMB
          , MCNTIPODI
          , MCNNRODI
          , MCNTIPTELE
          , MCNROTELE
          , MCNEMAIL
          , MCNDNI
          , MCNRUC
          , DISTRICODI
          , MCNFECNAC
          , CODCAT
          , MCNFECHREG
          , MCNHORA
          , SEXO) 
         VALUES
         (  ?
          , 'ERE04'
          , 'TPE01'
          , ?
          , ?
          , ?
          , NULL
          , NULL
          , NULL
          , NULL
          , NULL
          , NULL
          , NULL
          , NULL
          , ?
          , TRIM('DOI01')
          , ?
          , TRIM('02')
          , ?
          , ?
          , ?
          , NULL
          , ?
          , NULL
          , NULL
          , SYSDATE
          , TO_CHAR(SYSDATE,'HH24:MI:SS')
          , NULL)",
                [
                    $numeroContribuyente,
                    trim($apellidoPaterno),
                    trim($apellidoMaterno),
                    trim($nombres),
                    trim($apellidoPaterno . ' ' . $apellidoMaterno . ' ' . $nombres), // MCNAPENOMB
                    trim($dni),      // MCNNRODI
                    trim($celular),  // MCNROTELE
                    trim($email),    // MCNEMAIL
                    trim($dni),      // MCNDNI
                    $distrito        // DISTRICODI
                ]
            );
        }
        if ($request->inscriptionType == 'minor') {
            $inscripcion->ordenApoderado->update(
                ['numero_contribuyente' => $numeroContribuyente]
            );
        } else if ($request->inscriptionType == 'adult') {
            $inscripcion->ordenAlumno->update(
                ['numero_contribuyente' => $numeroContribuyente]
            );
        }
        return $numeroContribuyente;
    }
    public function generarSiguienteCorrelativo()
    {
        $ultimoContribuyente = Contribuyente::select('mcncontrib')->where('mcncontrib', 'like', 'T%')
            ->orderBy('mcncontrib', 'desc')
            ->first();
        if (!$ultimoContribuyente) {
            return 'T0000001';
        }
        // $con = '';
        $ultimoNumero = (int) Str::after($ultimoContribuyente->mcncontrib, 'T');

        $nuevoNumero = $ultimoNumero + 1;


        return 'T' . str_pad($nuevoNumero, 7, '0', STR_PAD_LEFT);
    }

    // --- Función: showCasiListo (GET) ---
    public function showCasiListo($token)
    {
        session()->forget('terminos_aceptados');
        try {
            $inscripcion = Inscripcion::where('reference_uuid', $token)->firstOrFail();
        } catch (Exception $e) {
            abort('403');
        }
        $idSeccion = $inscripcion->seccion_id;
        $vacantes = Seccion::where('id', $idSeccion)->value('vacantes');

        $countMatriculas = Matricula::where('seccion_id', $idSeccion)->where('estado', 'ACTIVA')->count();

        if ($countMatriculas >= $vacantes) {
            return redirect()->route('index')->with('error', 'La última vacante ya fue ocupada. No hay vacante');
        }
        if ($inscripcion && $inscripcion->estado === "PAGADO") {
            return redirect()->route('index')->with('info', "Ya se pagó esta transacción");
        }

        $tusne = $inscripcion->seccion->talleres->tusnes()->where('es_vecino', $inscripcion->es_vecino)->first();


        $monto = ServiciosTusne::where('congrupo', $tusne->grupo)->where('concodigo', $tusne->codigo)->value('conmonto');
        $numeroOrden = $inscripcion->numero_orden;
        $merchantId = env('MERCHANT_ID_DEV');


        $ordenApoderado = $inscripcion->ordenApoderado;
        $ordenAlumno = $inscripcion->ordenAlumno;

        $buyerData = [
            'seccion_id' => $inscripcion->seccion_id,
            'user_id' => $numeroOrden,
            'email' => ($inscripcion->tipo_inscripcion == 'minor') ? $ordenApoderado->email : $ordenAlumno->email,
            'phone' => ($inscripcion->tipo_inscripcion == 'minor') ? $ordenApoderado->celular : $ordenAlumno->celular,
            'doc_type' => 'DNI',
            'doc_number' => ($inscripcion->tipo_inscripcion == 'minor') ? $ordenApoderado->numero_documento : $ordenAlumno->numero_documento,
        ];

        $key = getAccessToken($numeroOrden, 'dev');
        $sessionToken = getSessionKey($merchantId, 'dev', $monto, $key, $numeroOrden, $buyerData);

        Session::put([
            'key' => $key, // Access Token
            'sessionToken' => $sessionToken // Token de Sesión
        ]);

        return response()->view('casi-listo', [
            'inscripcion' => $inscripcion,
            'sessionToken' => $sessionToken,
            'monto' => $monto
        ])->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
    public function procesandoPago($monto, $orden, $inscripcionId, Request $request)

    {
        return DB::transaction(function () use ($monto, $orden, $inscripcionId, $request) {
            // El lockForUpdate() hace que el Usuario B espere en esta lÃ­nea 
            // hasta que el Usuario A termine la transacción
            // dd($request->all());
            // $validateData = $request->validate([
            // 'acepto_terminos' => ['accepted']
            // ]);
            // dd(session('terminos_aceptados'));
            if (!session('terminos_aceptados')) {
                return redirect()->back()->with('error', 'Debe aceptar los términos y condiciones antes de proceder.');
            }
            $seccionId = Inscripcion::where('id', $inscripcionId)->value('seccion_id');

            $seccion = Seccion::where('id', $seccionId)->lockForUpdate()->first();

            $vacantes = $seccion->vacantes;
            $countMatriculas = Matricula::where('seccion_id', $seccionId)->where('estado', 'ACTIVA')->count();

            if ($countMatriculas >= $vacantes) {
                return redirect()->route('index')->with('error', '¡Lo sentimos! La última vacante se ocupó mientras procesabas tu solicitud. No se ha realizado ningún cobro.');
            }
            $dataTerminos = [
                'terminos_aceptados' => session('terminos_aceptados'),
                'ip_cliente' => $request->ip(),
                'fecha_aceptacion' => now()
            ];
            session()->forget('terminos_aceptados');
            $pagado = Inscripcion::where('id', $inscripcionId)->where('estado', 'PAGADO')->exists();
            if (!$pagado) {
                $merchantId = env('MERCHANT_ID_DEV');
                $key = session('key');

                $transactionToken = $request->transactionToken;

                $respuesta = authorization($merchantId, 'dev', $key, $monto, $transactionToken, $orden, storage_path('logs/talleres'));

                $httpStatus = $respuesta['status'];
                if ($httpStatus == 200) {
                    $actionCode = $respuesta['respuesta']['order']['actionCode'] ?? null;
                    if ($actionCode === '000') {
                        $arrayMat = $this->activarMatricula($inscripcionId, $respuesta['respuesta']['dataMap']['BRAND'], $monto, $dataTerminos);
                        $pago = $arrayMat['pago'];
                        $primeraCuotaId = $arrayMat['primeraCuota']->id;


                        $credentials = $arrayMat['credentials'];

                        $destino = $credentials['email'];

                        $this->guardarDatosPago($respuesta['respuesta'], $pago, $inscripcionId, $primeraCuotaId);
                        $pagosNiubiz = $pago->pagosNiubiz;
                        $pagosNiubiz->load(['cronogramasPagos', 'inscripcion.ordenAlumno', 'inscripcion.ordenApoderado']);


                        $inscripcion = $pago->pagosNiubiz->inscripcion;
                        $tusne = $inscripcion->seccion->talleres->tusnes()->where('es_vecino', $inscripcion->es_vecino)->first();
                        $paymentData = [
                            'nombre_cliente' => $pago->user->nombres,
                            'dni_cliente' => $pago->user->numero_documento,
                            'email_cliente' => $pago->user->email,
                            'numero_contribuyente' => $inscripcion->tipo_inscripcion == 'minor' ? $inscripcion->ordenApoderado->numero_contribuyente : $inscripcion->ordenAlumno->numero_contribuyente,
                            'numero_pedido' => $pagosNiubiz->num_orden_niubiz,
                            'numero_liquidacion' => $inscripcion->numero_liquidacion,
                            'numero_operacion' => $pagosNiubiz->id_unico,
                            'fecha_pedido' => $pago->fecha_pago->format('d/m/Y H:i A'),
                            'concepto' => $pago->cronogramaPago->concepto,
                            'grupo_codigo' => $tusne->grupo . ' - ' . $tusne->codigo,
                            // 'taller_seccion' => $pago->cronogramaPago->matricula->seccion->talleres->disciplina->nombre . ' - ' . $pago->cronogramaPago->matricula->seccion->nombre,
                            // 'frecuencia' => $inscripcion->seccion->talleres->frecuenciaVecino,
                            'nombre_alumno' => $pago->cronogramaPago->matricula->alumnos->user->nombres . ' ' . $pago->cronogramaPago->matricula->alumnos->user->apellido_paterno,
                            'periodo' => $pago->cronogramaPago->matricula->seccion->periodo->anio . '-' . $pago->cronogramaPago->matricula->seccion->periodo->ciclo,
                            'tipo_tarjeta' => $pagosNiubiz->brand, // Asumiendo que guardas estos datos en la tabla 'pagos'
                            'numero_tarjeta' => $pagosNiubiz->tarjeta_enmascarada,
                            'numero_token' => $pagosNiubiz->tokenId,
                            'monto_pagado' => $pagosNiubiz->monto_pagado
                        ];

                        $numeroLiquidacion = Inscripcion::where('id', $inscripcionId)->value('numero_liquidacion');
                        DB::connection('oracle')->table('smacargo')->where('cgonumero', $numeroLiquidacion)->update(
                            [
                                'cgogestado' => 'ERE02'
                            ]
                        );
                        try {
                            Mail::to($destino)->queue(new ConfirmaciónPagoMail($pagosNiubiz, $credentials));
                            Mail::to($destino)->queue(new ComprobantePagoMail($paymentData));


                            Log::info("ÉXITO: Correo enviado a {$destino}");
                        } catch (\Exception $e) {
                            Log::error("ERROR CRÍTICO AL ENVIAR CORREO: " . $e->getMessage());
                            // Aquí NO limpiamos la fecha para que el sistema intente de nuevo si usas release()
                        }
                        session(['pagosNiubiz' => $pagosNiubiz]);
                        session()->forget('paymentData');
                        return redirect()->route('talleres.inscripcion.respuesta');
                    }
                } else {
                    $descripcion = $respuesta['respuesta']['data']['ACTION_DESCRIPTION'] ?? 'Error desconocido.';
                    $this->guardarDatosPagoFallido($respuesta['respuesta'], $inscripcionId);
                    $uuidInscripcion = Inscripcion::where('id', $inscripcionId)->value('reference_uuid');
                    $paymentData = [
                        'numero_pedido' => $orden,
                        'descripcion_denegacion' => $descripcion,
                        'token_inscripcion' => $uuidInscripcion
                    ];
                    session(['paymentData' => $paymentData]);
                    session()->forget('pagosNiubiz');
                    // return back()->with('error', $descripcion.'N° Orden:'.$orden);
                    // dd('no es 200');
                    return redirect()->route('talleres.inscripcion.respuesta');
                }
            } else {
                return back()->with('info', 'Taller ya pagado.');
            }
        });
    }
    public function guardarDatosPago($respuesta, $pago, $inscripcionId, $primeraCuotaId)
    {
        $pagosNiubiz = PagosNiubiz::create([
            'num_orden_niubiz' => $respuesta['order']['purchaseNumber'] ?? null,
            'id_transaccion_niubiz' => $respuesta['order']['transactionId'] ?? null,
            'codigo_autorizacion' => $respuesta['order']['authorizationCode'] ?? null,
            'monto_pagado' => $respuesta['order']['amount'] ?? null,
            'moneda' => $respuesta['order']['currency'] ?? null,
            'marca_tarjeta' => $respuesta['dataMap']['BRAND_NAME'] ?? null,
            'tarjeta_enmascarada' => $respuesta['dataMap']['CARD'] ?? null,
            'codigo_accion' => $respuesta['order']['actionCode'] ?? null,
            'descripcion_estado' => $respuesta['dataMap']['ACTION_DESCRIPTION'] ?? null,
            'fecha_transaccion' => $respuesta['order']['transactionDate'] ?? null,
            'ecoreTransactionUUID' => $respuesta['header']['ecoreTransactionUUID'] ?? null,
            'merchantId' => $respuesta['fulfillment']['merchantId'] ?? null,
            'terminalId' => $respuesta['fulfillment']['terminalId'] ?? null,
            'captureType' => $respuesta['fulfillment']['captureType'] ?? null,
            'tokenId' => $respuesta['order']['tokenId'] ?? null,
            'estado' => $respuesta['dataMap']['STATUS'] ?? null,
            'eci_descripcion' => $respuesta['dataMap']['ECI_DESCRIPTION'] ?? null,
            'json_niubiz' => json_encode($respuesta) ?? null,
            'id_unico' => $respuesta['dataMap']['ID_UNICO'] ?? null,
            'brand' => $respuesta['dataMap']['BRAND'] ?? null,
            'inscripcion_id' => $inscripcionId ?? null,
            'cronograma_pago_id' => $primeraCuotaId ?? null,
            'trace_number' => $respuesta['order']['traceNumber'] ?? null,
            'id_resolutor' => $respuesta['dataMap']['ID_RESOLUTOR'] ?? null,
            'signature' => $respuesta['dataMap']['SIGNATURE'] ?? null,
            'authorization_code' => $respuesta['dataMap']['AUTHORIZATION_CODE'] ?? null,



        ]);

        $pago->pagos_niubiz_id = $pagosNiubiz->id;
        $pago->save();
    }
    public function guardarDatosPagoFallido($respuesta, $inscripcionId)
    {
        $pagosNiubiz = PagosNiubiz::create([
            // 'num_orden_niubiz' => $respuesta['order']['purchaseNumber'] ?? null,
            'id_transaccion_niubiz' => $respuesta['data']['TRANSACTION_ID'] ?? null,
            // 'codigo_autorizacion' => $respuesta['order']['authorizationCode'] ?? null,
            // 'monto_pagado' => $respuesta['order']['amount'] ?? null,
            // 'moneda' => $respuesta['order']['currency'] ?? null,
            'marca_tarjeta' => $respuesta['data']['BRAND_NAME'] ?? null,
            'tarjeta_enmascarada' => $respuesta['data']['CARD'] ?? null, /////////
            'codigo_accion' => $respuesta['data']['ACTION_CODE'] ?? null,
            'descripcion_estado' => $respuesta['data']['ACTION_DESCRIPTION'] ?? null, ////////
            // 'fecha_transaccion' => $respuesta['header']['transactionDate'] ?? null,
            'ecoreTransactionUUID' => $respuesta['header']['ecoreTransactionUUID'] ?? null,
            'merchantId' => $respuesta['data']['MERCHANT'] ?? null,
            // 'terminalId' => $respuesta['fulfillment']['terminalId'] ?? null,
            // 'captureType' => $respuesta['fulfillment']['captureType'] ?? null,
            // 'tokenId' => $respuesta['order']['tokenId'] ?? null,
            'estado' => $respuesta['data']['STATUS'] ?? null, ///////
            'eci_descripcion' => $respuesta['data']['ECI_DESCRIPTION'] ?? null, ///////////
            'json_niubiz' => json_encode($respuesta) ?? null,
            'id_unico' => $respuesta['data']['ID_UNICO'] ?? null,
            'brand' => $respuesta['data']['BRAND'] ?? null, ///////
            'inscripcion_id' => $inscripcionId ?? null,
            'cronograma_pago_id' => $primeraCuotaId ?? null,
            'trace_number' => $respuesta['data']['TRACE_NUMBER'] ?? null, //////////
            'signature' => $respuesta['data']['SIGNATURE'] ?? null, ////////////////

        ]);
    }


    private function activarMatricula($inscripcionId, $formaPago, $monto, $dataTerminos)
    {
        $usuarioResponsable = null;
        $perfilAlumno = null;

        $inscripcion = Inscripcion::findOrFail($inscripcionId);
        $ordenApoderado = $inscripcion->ordenApoderado;
        $ordenAlumno = $inscripcion->ordenAlumno;

        $inscripcion->estado = 'PAGADO';
        $inscripcion->save();
        // Lógica de "Buscar o Crear" usuarios (la que ya teníamos)
        $credentials = [];
        if ($inscripcion->tipo_inscripcion === 'minor') {

            $usuarioResponsable = User::firstOrCreate(['numero_documento' => $ordenApoderado->numero_documento], [
                'nombres' => $ordenApoderado->nombres,
                'apellido_paterno' => $ordenApoderado->apellido_paterno,
                'apellido_materno' => $ordenApoderado->apellido_materno,
                'telefono' => $ordenApoderado->celular,
                'direccion' => $ordenApoderado->direccion,
                'email' => $ordenApoderado->email,
                'password' => Hash::make($ordenApoderado->numero_documento),
                'role' => 'PADRE',
                'tipo_documento' => 'DNI'
            ]);

            $ordenApoderado->user_id = $usuarioResponsable->id;
            $ordenApoderado->save();

            if ($usuarioResponsable->role->value === 'ALUMNO') {

                $usuarioResponsable->update(['role' => 'PADRE']);
            }
            if ($usuarioResponsable->role->value === 'DOCENTE') {

                $usuarioResponsable->update([
                    'telefono' => $ordenApoderado->celular,
                    'direccion' => $ordenApoderado->direccion,
                    'fecha_nacimiento' => $ordenApoderado->fecha_nacimiento,
                    'numero_conadis' => $ordenApoderado->numero_conadis
                ]);
            }

            $usuarioResponsable->padre()->firstOrCreate([]);

            $perfilAlumno = User::firstOrCreate(['numero_documento' => $ordenAlumno->numero_documento], [
                'nombres' => $ordenAlumno->nombres,
                'apellido_paterno' => $ordenAlumno->apellido_paterno,
                'apellido_materno' => $ordenAlumno->apellido_materno,
                'fecha_nacimiento' => $ordenAlumno->fecha_nacimiento,
                'role' => 'ALUMNO',
                'tipo_documento' => 'DNI',
                'numero_conadis' => $ordenAlumno->numero_conadis
            ]);

            $perfilAlumno->alumno()->updateOrCreate(['user_id' => $perfilAlumno->id], ['padre_id' => $usuarioResponsable->id]);
        } else { // 'adult'


            $usuarioResponsable = User::firstOrCreate(['numero_documento' => $ordenAlumno->numero_documento], [
                'nombres' => $ordenAlumno->nombres,
                'apellido_paterno' => $ordenAlumno->apellido_paterno,
                'apellido_materno' => $ordenAlumno->apellido_materno,
                'email' => $ordenAlumno->email, // Comentamos la línea original
                'telefono' => $ordenAlumno->celular,
                'direccion' => $ordenAlumno->direccion,
                'password' => Hash::make($ordenAlumno->numero_documento),
                'fecha_nacimiento' => $ordenAlumno->fecha_nacimiento,
                'role' => 'ALUMNO',
                'tipo_documento' => 'DNI',
                'numero_conadis' => $ordenAlumno->numero_conadis
                // 'activo' => 1
            ]);
            if ($usuarioResponsable->role->value === 'DOCENTE') {

                $usuarioResponsable->update([
                    'telefono' => $ordenAlumno->celular,
                    'direccion' => $ordenAlumno->direccion,
                    'fecha_nacimiento' => $ordenAlumno->fecha_nacimiento,
                    'numero_conadis' => $ordenAlumno->numero_conadis
                ]);
            }
            $ordenAlumno->user_id = $usuarioResponsable->id;
            $ordenAlumno->save();
            // dd($usuarioResponsable->toArray());
            $usuarioResponsable->alumno()->firstOrCreate(['padre_id' => null]);
            $perfilAlumno = $usuarioResponsable;
        }
        $credentials['email'] = $usuarioResponsable->email;
        $credentials['password'] = $usuarioResponsable->numero_documento;
        $inscripcion = Inscripcion::findOrFail($inscripcionId);
        $inscripcion->user_id = $usuarioResponsable->id;
        $inscripcion->save();

        // Crear la Matrícula
        $matricula = Matricula::firstOrCreate(
            [
                'alumno_id' => $perfilAlumno->id,
                'seccion_id' => $inscripcion->seccion_id,
            ],
            [
                'orden_id' => $inscripcion->id,

                'estado' => 'ACTIVA',

            ]
        );

        // $matricula->load('seccion');
        //===============================GENERA CRONOGRAMA MENSUAL=============================
        // $this->generarCronograma($matricula->id, $inscripcion->monto, $inscripcion->seccion->fecha_inicio, $inscripcion->seccion->fecha_fin);
        $cronograma = $this->generarUnicoCronograma($matricula->id, $monto);
        // $primeraCuota = CronogramaPago::where('matricula_id', $matricula->id)->orderBy('fecha_vencimiento', 'asc')->first();
        $pago = Pago::create([
            'monto_pagado' => $monto,
            'fecha_pago' => now(),
            'numero_orden' => $inscripcion->numero_orden,
            'user_id' => $usuarioResponsable->id,
            'cronograma_pago_id' => $cronograma->id,
            'metodo_pago' => $formaPago,
            'terminos_aceptados' => $dataTerminos['terminos_aceptados'],
            'ip_cliente' => $dataTerminos['ip_cliente'],
            'fecha_aceptacion' => $dataTerminos['fecha_aceptacion']
        ]);
        $cronograma->estado = 'PAGADO';
        $cronograma->fecha_pago = now();
        $cronograma->save();
        // $nombreMes = now()->locale('es')->monthName;
        // $matricula->cronogramaPagos()->create([
        //     'concepto' => 'Mensualidad ' . $nombreMes,
        //     'monto' => $preInscripcion->monto,
        //     // 'fecha_vencimiento' => 
        // ]);
        // Generar Cronograma de Pagos (la primera cuota ya está pagada)
        // ... tu lógica para crear el cronograma ...

        // Enviar Correo de Bienvenida
        // Mail::to($usuarioResponsable->email)->send(new BienvenidaTaller($usuarioResponsable));
        return [
            'pago' => $pago,
            'primeraCuota' => $cronograma,
            'credentials' =>  $credentials
        ];
    }
    public function generarUnicoCronograma($matricula_id, $monto)
    {
        $matricula = Matricula::findOrFail($matricula_id);
        $seccion = $matricula->seccion;
        $disciplina = $matricula->seccion->talleres->disciplina;
        $categoria = $matricula->seccion->talleres->categoria;
        $periodo = $matricula->seccion->periodo;
        $taller = $matricula->seccion->talleres;
        $nombrePeriodo = "$periodo->anio-$periodo->ciclo";
        if ($categoria->tiene_discapacidad) {
            $nombreCategoria = "Para personas con discapacidad";
        } else if ($categoria->edad_min && $categoria->edad_max) {
            $nombreCategoria = "De $categoria->edad_min a $categoria->edad_max años";
        } else if ($categoria->edad_min) {
            $nombreCategoria = "De $categoria->edad_min años a más";
        } else {
            $nombreCategoria = "Todas las edades";
        }


        $cronograma = CronogramaPago::updateOrCreate(
            ['matricula_id' => $matricula_id,],
            [
                'concepto' => "$disciplina->nombre - $seccion->nombre ($nombreCategoria) - $nombrePeriodo - $taller->frecuenciaVecino",
                'monto' => $monto,
                'fecha_vencimiento' => null,
                'estado' => 'PENDIENTE'
            ]
        );
        return $cronograma;
    }
    // public function generarCronograma(int $matricula_id, float $monto, string $fechaInicio, string $fechaFin)
    // {

    //     $monto = $monto ?? 0.00;
    //     $diaCorte = 25;
    //     // $monto = 0;
    //     $inicio = Carbon::parse($fechaInicio);
    //     $fin = Carbon::parse($fechaFin);

    //     $fechaPrimerVencimiento = $inicio->copy()->day($diaCorte);

    //     if ($fechaPrimerVencimiento->lessThanOrEqualTo($fechaInicio)) {
    //         $fechaPrimerVencimiento->addMonth();
    //     }
    //     $fechaActual =  $fechaPrimerVencimiento;
    //     $pagosParaInsertar = [];
    //     Carbon::setLocale('es');
    //     // $esPrimerPago = true;

    //     while ($fechaActual->lessThanOrEqualTo($fin)) {

    //         $fechaVencimiento = $fechaActual->copy()->day($diaCorte);
    //         if ($fechaVencimiento->greaterThan($fin)) {
    //             break;
    //         }
    //         $nombreDelMes = $fechaVencimiento->monthName;
    //         $estadoPago = 'PENDIENTE';
    //         // if ($esPrimerPago) {
    //         //     $estadoPago = 'PAGADO';
    //         //     $esPrimerPago = false;
    //         // }

    //         $pagosParaInsertar[] = [
    //             'matricula_id' => $matricula_id,
    //             'concepto' => 'Mensualidad ' . $nombreDelMes . ' ' . $fechaVencimiento->year,
    //             'monto' => $monto,
    //             'fecha_vencimiento' => $fechaVencimiento->toDateString(),
    //             'estado' => $estadoPago

    //         ];
    //         $fechaActual->addMonth();
    //     }
    //     // dd($pagosParaInsertar);
    //     CronogramaPago::insert($pagosParaInsertar);
    //     return count($pagosParaInsertar);
    // }
    public function verificarPorDni($dni)
    {
        // Buscamos al usuario por su DNI
        $usuario = User::where('numero_documento', $dni)
            ->with(['inscripcion'])->first();

        if ($usuario) {
            // Si lo encontramos, devolvemos sus datos
            $distrito = null;
            $codigoDistrito =  null;
            if ($usuario->email != null) {
                $inscripcion = $usuario->inscripcion;



                if ($inscripcion->tipo_inscripcion == 'minor') {
                    $distrito =  $inscripcion->ordenApoderado->distrito;
                    $codigoDistrito =  $inscripcion->ordenApoderado->codigo_distrito;
                } else {
                    $distrito =  $inscripcion->ordenAlumno->distrito;
                    $codigoDistrito =  $inscripcion->ordenAlumno->codigo_distrito;
                }
            }
            return response()->json([
                'encontrado' => true,
                'usuario' => [
                    'nombres' => $usuario->nombres,
                    'apellido_paterno' => $usuario->apellido_paterno,
                    'apellido_materno' => $usuario->apellido_materno,
                    'email' => $usuario->email,
                    'celular' => $usuario->telefono,
                    'direccion' => $usuario->direccion,
                    'distrito' => $distrito,
                    'codigo_distrito' => $codigoDistrito
                    // ... otros datos que quieras devolver ...
                ]
            ]);
        } else {
            // Si no, devolvemos que no se encontró
            return response()->json(['encontrado' => false]);
        }
    }

    public function generarComprobantePago($idCifrado)
    {
        try {

            $id = Crypt::decryptString($idCifrado);
        } catch (DecryptException $e) {

            abort(404, 'Enlace no válido o expirado.');
        }
        $pago = Pago::findOrFail($id);
        $pagosNiubiz = $pago->pagosNiubiz;
        $inscripcion = $pago->pagosNiubiz->inscripcion;
        $tusne = $inscripcion->seccion->talleres->tusnes()->where('es_vecino', $inscripcion->es_vecino)->first();
        $paymentData = [
            'nombre_cliente' => $pago->user->nombres,
            'dni_cliente' => $pago->user->numero_documento,
            'numero_contribuyente' => $inscripcion->tipo_inscripcion == 'minor' ? $inscripcion->ordenApoderado->numero_contribuyente : $inscripcion->ordenAlumno->numero_contribuyente,
            'email_cliente' => $pago->user->email,
            'numero_pedido' => $pagosNiubiz->num_orden_niubiz,
            'numero_liquidacion' => $inscripcion->numero_liquidacion,
            'numero_operacion' => $pagosNiubiz->id_unico,
            'fecha_pedido' => $pago->fecha_pago->format('d/m/Y H:i A'),
            'concepto' => $pago->cronogramaPago->concepto,
            'grupo_codigo' => $tusne->grupo . ' - ' . $tusne->codigo,
            // 'frecuencia' => $inscripcion->seccion->talleres->frecuenciaVecino,
            // 'taller_seccion' => $pago->cronogramaPago->matricula->seccion->talleres->disciplina->nombre . ' - ' . $pago->cronogramaPago->matricula->seccion->nombre,
            'nombre_alumno' => $pago->cronogramaPago->matricula->alumnos->user->nombres . ' ' . $pago->cronogramaPago->matricula->alumnos->user->apellido_paterno,
            'periodo' => $pago->cronogramaPago->matricula->seccion->periodo->anio . '-' . $pago->cronogramaPago->matricula->seccion->periodo->ciclo,
            'tipo_tarjeta' => $pagosNiubiz->brand, // Asumiendo que guardas estos datos en la tabla 'pagos'
            'numero_tarjeta' => $pagosNiubiz->tarjeta_enmascarada,
            'numero_token' => $pagosNiubiz->tokenId,
            'monto_pagado' => $pagosNiubiz->monto_pagado
        ];

        // 3. Cargar la vista y generar el PDF
        $pdf = Pdf::loadView('pdf.comprobante-pago', compact('paymentData'));

        // 4. Descargar el PDF en el navegador del usuario
        //    El nombre del archivo será dinámico, ej. "comprobante-pago-123.pdf"

        $pdf->setPaper('a6');
        return $pdf->stream('comprobante-pago-' . $pago->id . '.pdf');
    }

    public function ws_reniec($dni)
    {
        // 1. LIBERAR SESIÃ“N (Crucial para evitar el 504 en el navegador)

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        // 1. Desactivar caché de WSDL para evitar bloqueos de archivos temporales
        // ini_set('soap.wsdl_cache_enabled', 1);
        // ini_set('soap.wsdl_cache_ttl', 86400); // Guardarlo por un día

        //ini_set('soap.wsdl_cache_enabled', 0);
        //ini_set('soap.wsdl_cache_ttl', 0);
        /*
$context = stream_context_create([
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
    'http' => ['timeout' => 15] // Timeout a nivel de socket
]);*/
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ],
            'socket' => [
                'bindto' => '0:0', // Esto ayuda a forzar la selección de interfaz
                'tcp_nodelay' => true
            ],
            'http' => [
                'timeout' => 10,
                'header' => "Connection: close\r\n"
            ]
        ]);

        $nro_documento = $dni;
        $tipo = 'JS';
        $nro_docu = trim($nro_documento);

        $registro = array(
            'codResu' => '99',
            'detResu' => 'Error desconocido', // Este es el valor por defecto que estÃƒÂ¡s viendo
            'paterno' => '',
            'materno' => '',
            'nombre' => '',
            'foto' => '',
            'restriccion' => ''
        );

        $parametros = array(
            "arg0" => array(
                "nuDniConsulta" => $nro_docu,
                "nuDniUsuario"  => env('PIDE_USER'),
                "nuRucUsuario"  => env('PIDE_RUC'),
                "password"      => env('PIDE_PASS')
            )
        );

        try {
            // 2. No descargues el WSDL cada vez, usa el modo "non-WSDL" o fuerza el timeout
            $time_start = microtime(true);

            $wsdl_local = base_path('resources/wsdl/reniec.wsdl');
            $client = new SoapClient($wsdl_local, [
                'location' => env('PIDE_URL'),
                'trace' => 1,
                'soap_version' => SOAP_1_1,
                'stream_context' => $context,
                'connection_timeout' => 10, // Si en 10s no conecta, muere
                'exceptions' => true
            ]);
            Log::info("Tiempo solo para conectar SOAP: " . (microtime(true) - $time_start));
            $response = $client->consultar($parametros);

            // --- CORRECCIÃƒâ€œN PRINCIPAL AQUÃƒÂ ---
            $obj = null;

            // 1. Verificamos si existe la propiedad 'return' (EstÃƒÂ¡ndar PIDE)
            if (isset($response->return)) {
                $obj = $response->return;
            }
            // 2. Si no, verificamos si es un array
            else if (is_array($response) && isset($response[0])) {
                $obj = $response[0];
                // A veces el array contiene el objeto return
                if (isset($obj->return)) $obj = $obj->return;
            }
            // 3. Si no, asumimos que es el objeto directo
            else {
                $obj = $response;
            }

            // --- VALIDACIÃƒâ€œN DE DATOS ---
            if (isset($obj->coResultado)) {
                $registro['codResu'] = (string)$obj->coResultado;
                $registro['detResu'] = (string)$obj->deResultado;

                if ($registro['codResu'] === '0000') {





                    $d = $obj->datosPersona;

                    $ubigeoPIDE = (string) $d->ubigeo;

                    $ubigeoArray = explode('/', $ubigeoPIDE);

                    $codigoDist = '999';
                    $nombreDist = 'DISTRITO FUERA DE LIMA';
                    if (trim(($ubigeoArray[0]) == 'LIMA' && trim($ubigeoArray[1]) == 'LIMA' && count($ubigeoArray) == 3)) {

                        $distrito = trim($ubigeoArray[2]);
                        $distritoPIDE = $this->normalizarTexto($distrito);
                        $objDistrito = Distrito::select('districodi', 'distridesc')->where('distridesc', 'like', "%{$distritoPIDE}%")->first();
                        $nombreDist = $objDistrito->distridesc;
                        $codigoDist = $objDistrito->districodi;
                    } else if (trim($ubigeoArray[0]) == 'CALLAO' && count($ubigeoArray) == 2) {

                        $distrito = trim($ubigeoArray[1]);
                        $distrito = str_ireplace('-REYNOSO', '', $distrito);
                        $distritoPIDE = $this->normalizarTexto($distrito);
                        $objDistrito = Distrito::select('districodi', 'distridesc')->where('distridesc', 'like', "%{$distritoPIDE}%")->first();
                        $nombreDist = $objDistrito->distridesc;
                        $codigoDist = $objDistrito->districodi;
                    }


                    $registro['paterno']     = (string)$d->apPrimer;
                    $registro['materno']     = (string)$d->apSegundo;
                    $registro['nombre']      = (string)$d->prenombres;
                    // $registro['estadocivil'] = (string)$d->estadoCivil;
                    $registro['direccion']   = (string)$d->direccion;
                    $registro['codigoDist']      = (string) $codigoDist;
                    $registro['nombreDist']      = (string) $nombreDist;
                    // $registro['restriccion'] = (string)$d->restriccion;



                    // if (!empty($d->foto)) {

                    //     $folderPath = public_path("uploads/foto_dni/");


                    //     if (!file_exists($folderPath)) {
                    //         mkdir($folderPath, 0777, true);
                    //     }

                    //     $fileName = $nro_docu . ".png";
                    //     $fullPath = $folderPath . $fileName;


                    //     file_put_contents($fullPath, $d->foto);
                    //     $registro['foto'] = $nro_docu;
                    // }
                }
            } else {
                // DEPURACIÃƒâ€œN: Si llega aquÃƒÂ­, veremos quÃƒÂ© estructura devolviÃƒÂ³ realmente PIDE
                // Convertimos la respuesta a texto para verla en el mensaje de error
                $dump = print_r($response, true);
                $registro['detResu'] = "Estructura no reconocida. Respuesta cruda: " . substr($dump, 0, 200) . "...";
            }
        } catch (SoapFault $e) {
            $registro['detResu'] = "Error SOAP: " . $e->getMessage();
            Log::error("RENIEC CaÃ­do o Bloqueado: " . $e->getMessage());
        } catch (Exception $exc) {
            $registro['detResu'] = "Error General: " . $exc->getMessage();
            Log::error("RENIEC CaÃ­do o Bloqueado: " . $exc->getMessage());
        }

        // if ($tipo == 'JS') {
        //     // Limpiar buffer para evitar HTML basura antes del JSON
        //     if (ob_get_length()) ob_clean();
        //     header('Content-Type: application/json; charset=utf-8');
        //     return json_encode($registro);
        //     // exit;
        // } else {
        //     return $registro;
        // }
        return response()->json($registro);
    }

    public function ws_reniec1($dni)
    {
        // 1. LIBERAR SESIÃ“N (Crucial para evitar el 504 en el navegador)

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        // 1. Desactivar caché de WSDL para evitar bloqueos de archivos temporales
        // ini_set('soap.wsdl_cache_enabled', 1);
        // ini_set('soap.wsdl_cache_ttl', 86400); // Guardarlo por un día

        //ini_set('soap.wsdl_cache_enabled', 0);
        //ini_set('soap.wsdl_cache_ttl', 0);
        /*
$context = stream_context_create([
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
    'http' => ['timeout' => 15] // Timeout a nivel de socket
]);*/
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ],
            'socket' => [
                'bindto' => '0:0', // Esto ayuda a forzar la selección de interfaz
                'tcp_nodelay' => true
            ],
            'http' => [
                'timeout' => 10,
                'header' => "Connection: close\r\n"
            ]
        ]);

        $nro_documento = $dni;
        $tipo = 'JS';
        $nro_docu = trim($nro_documento);

        $registro = array(
            'codResu' => '99',
            'detResu' => 'Error desconocido', // Este es el valor por defecto que estÃƒÂ¡s viendo
            'paterno' => '',
            'materno' => '',
            'nombre' => '',
            'foto' => '',
            'restriccion' => ''
        );

        $parametros = array(
            "arg0" => array(
                "nuDniConsulta" => $nro_docu,
                "nuDniUsuario"  => env('PIDE_USER'),
                "nuRucUsuario"  => env('PIDE_RUC'),
                "password"      => env('PIDE_PASS')
            )
        );

        try {
            // 2. No descargues el WSDL cada vez, usa el modo "non-WSDL" o fuerza el timeout
            $time_start = microtime(true);

            $wsdl_local = base_path('resources/wsdl/reniec.wsdl');
            $client = new SoapClient($wsdl_local, [
                'location' => env('PIDE_URL'),
                'trace' => 1,
                'soap_version' => SOAP_1_1,
                'stream_context' => $context,
                'connection_timeout' => 10, // Si en 10s no conecta, muere
                'exceptions' => true
            ]);
            Log::info("Tiempo solo para conectar SOAP: " . (microtime(true) - $time_start));
            $response = $client->consultar($parametros);

            // --- CORRECCIÃƒâ€œN PRINCIPAL AQUÃƒÂ ---
            $obj = null;

            // 1. Verificamos si existe la propiedad 'return' (EstÃƒÂ¡ndar PIDE)
            if (isset($response->return)) {
                $obj = $response->return;
            }
            // 2. Si no, verificamos si es un array
            else if (is_array($response) && isset($response[0])) {
                $obj = $response[0];
                // A veces el array contiene el objeto return
                if (isset($obj->return)) $obj = $obj->return;
            }
            // 3. Si no, asumimos que es el objeto directo
            else {
                $obj = $response;
            }

            // --- VALIDACIÃƒâ€œN DE DATOS ---
            if (isset($obj->coResultado)) {
                $registro['codResu'] = (string)$obj->coResultado;
                $registro['detResu'] = (string)$obj->deResultado;

                if ($registro['codResu'] === '0000') {





                    $d = $obj->datosPersona;




                    $registro['paterno']     = (string)$d->apPrimer;
                    $registro['materno']     = (string)$d->apSegundo;
                    $registro['nombre']      = (string)$d->prenombres;
                    $registro['estadocivil'] = (string)$d->estadoCivil;
                    $registro['direccion']   = (string)$d->direccion;
                    $registro['ubigeo']      = (string) $d->ubigeo;
                    $registro['restriccion'] = (string)$d->restriccion;
                }
            } else {
                // DEPURACIÃƒâ€œN: Si llega aquÃƒÂ­, veremos quÃƒÂ© estructura devolviÃƒÂ³ realmente PIDE
                // Convertimos la respuesta a texto para verla en el mensaje de error
                $dump = print_r($response, true);
                $registro['detResu'] = "Estructura no reconocida. Respuesta cruda: " . substr($dump, 0, 200) . "...";
            }
        } catch (SoapFault $e) {
            $registro['detResu'] = "Error SOAP: " . $e->getMessage();
            Log::error("RENIEC CaÃ­do o Bloqueado: " . $e->getMessage());
        } catch (Exception $exc) {
            $registro['detResu'] = "Error General: " . $exc->getMessage();
            Log::error("RENIEC CaÃ­do o Bloqueado: " . $exc->getMessage());
        }

        // if ($tipo == 'JS') {
        //     // Limpiar buffer para evitar HTML basura antes del JSON
        //     if (ob_get_length()) ob_clean();
        //     header('Content-Type: application/json; charset=utf-8');
        //     return json_encode($registro);
        //     // exit;
        // } else {
        //     return $registro;
        // }
        return response()->json($registro);
    }
    public function normalizarTexto($texto)
    {
        $originales = ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'á', 'é', 'í', 'ó', 'ú', 'ü'];
        $modificados = ['A', 'E', 'I', 'O', 'U', 'U', 'A', 'E', 'I', 'O', 'U', 'U'];
        $texto = str_replace($originales, $modificados, strtoupper($texto));
        return trim($texto);
    }

    public function enviarCodigo(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // 1. Generar código aleatorio
        $code = rand(100000, 999999);

        // 2. Guardar en la DB (o actualizar si ya existe para ese correo)
        EmailVerification::updateOrCreate(
            ['email' => $request->email],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(15) // El código expira en 15 min
            ]
        );

        // 3. Enviar el correo (Usando un Mailable de Laravel)
        Mail::to($request->email)->queue(new VerificacionCodigoMail($code));

        return response()->json(['message' => 'Código enviado con éxito']);
    }
}
