<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Capacitación - INSN Breña</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-primary: #004a99;
            --blue-secondary: #007bff;
            --blue-light: #e7f1ff;
            --blue-dark: #003366;
            --text-color: #333;
            --border-color: #ced4da;
            --success-color: #28a745;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-top: 8px solid var(--blue-primary);
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-placeholder {
            font-weight: bold;
            color: var(--blue-primary);
            font-size: 1.2rem;
            margin-bottom: 10px;
            display: block;
        }

        h1 {
            font-size: 1.4rem;
            color: var(--blue-dark);
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        p.subtitle {
            font-size: 0.9rem;
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--blue-dark);
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--blue-secondary);
            box-shadow: 0 0 0 3px rgba(0,123,255,0.2);
        }

        .helper-text {
            font-size: 0.8rem;
            color: #777;
            margin-top: 4px;
        }

        .section-title {
            background-color: var(--blue-light);
            padding: 10px 15px;
            border-radius: 4px;
            margin: 30px 0 20px 0;
            font-size: 1.1rem;
            color: var(--blue-primary);
            font-weight: bold;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: var(--blue-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
        }

        button:hover {
            background-color: var(--blue-dark);
        }

        .hidden { display: none; }

        /* Estilo para simular carga de base de datos */
        .loading-select {
            font-style: italic;
            color: var(--blue-secondary);
        }

        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .container { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <span class="logo-placeholder">INSN - BREÑA</span>
        <h1>Plan de Capacitación 2026</h1>
        <p class="subtitle">Diagnóstico y manejo de patologías prevalentes de la infancia, detección temprana de patologías congénitas y adquiridas en la primera infancia.</p>
    </header>

    <form id="registroForm" method="POST" action="{{route('form.inscripciones.store')}}">
        @csrf
        <div class="section-title">Datos del Participante</div>
        <input type="hidden" value="{{$seccion_id}}" name="seccion_id">
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" placeholder="Ej. Juan" required>
        </div>
        <div class="form-group">
            <label for="nombres">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Ej. Pérez" required>
        </div>
        {{-- <div class="form-group">
            <label for="nombres">Apellido Materno</label>
            <input type="text" id="apellido_materno" name="apellido_materno" placeholder="Ej. García" required>
        </div> --}}

        <div class="form-row">
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" maxlength="8" pattern="\d{8}" placeholder="8 dígitos" required>
                <p class="helper-text">Solo números (8 dígitos)</p>
            </div>
            <div class="form-group">
                <label for="colegiatura">Colegiatura</label>
                <input type="text" id="colegiatura" name="colegiatura" placeholder="N° de Colegiatura" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="profesion">Profesión</label>
                <select id="profesion" name="profesion" required>
                    <option value="">Seleccione...</option>
                    <option value="Medico">Médico</option>
                    <option value="Enfermera">Enfermera</option>
                    <option value="Tecnico">Técnico en Enfermería</option>
                    <option value="Psicologo">Psicólogo</option>
                    <option value="Otros">Otros Profesionales de la Salud</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nivel">Nivel del Establecimiento</label>
                <select id="nivel" name="nivel" required>
                    <option value="">Seleccione...</option>
                    <option value="I-1">I-1</option>
                    <option value="I-2">I-2</option>
                    <option value="I-3">I-3</option>
                    <option value="I-4">I-4</option>
                    <option value="II-1">II-1</option>
                    <option value="II-2">II-2</option>
                </select>
            </div>
        </div>

        <div class="section-title">Ubicación y Establecimiento (SUSALUD)</div>

        <div class="form-group">
            <label for="region_vivienda">Región / Departamento</label>
            <select id="region_vivienda" name="region_vivienda" required onchange="handleRegionChange()">
                <option value="">Seleccione Región...</option>
                <option value="LIMA">Lima Provincia</option>
                <option value="CALLAO">Callao</option>
                <option value="AMAZONAS">Amazonas</option>
                <option value="ANCASH">Ancash</option>
                <option value="APURIMAC">Apurímac</option>
                <option value="AREQUIPA">Arequipa</option>
                <option value="AYACUCHO">Ayacucho</option>
                <option value="CAJAMARCA">Cajamarca</option>
                <option value="CUSCO">Cusco</option>
                <option value="HUANCAVELICA">Huancavelica</option>
                <option value="HUANUCO">Huánuco</option>
                <option value="ICA">Ica</option>
                <option value="JUNIN">Junín</option>
                <option value="LA LIBERTAD">La Libertad</option>
                <option value="LAMBAYEQUE">Lambayeque</option>
                <option value="LIMA_REGION">Lima Región</option>
                <option value="LORETO">Loreto</option>
                <option value="MADRE_DE_DIOS">Madre de Dios</option>
                <option value="MOQUEGUA">Moquegua</option>
                <option value="PASCO">Pasco</option>
                <option value="PIURA">Piura</option>
                <option value="PUNO">Puno</option>
                <option value="SAN_MARTIN">San Martín</option>
                <option value="TACNA">Tacna</option>
                <option value="TUMBES">Tumbes</option>
                <option value="UCAYALI">Ucayali</option>
            </select>
        </div>

        <div class="form-group" id="diris_container">
            <label id="diris_label" for="diris_diresa">DIRIS / DIRESA Perteneciente</label>
            <select id="diris_diresa" name="diris_diresa" required>
                <option value="">Primero seleccione una región...</option>
            </select>
        </div>

        <div class="form-group">
            <label for="establecimiento">Nombre del Establecimiento</label>
            <select id="establecimiento" name="establecimiento" required>
                <option value="">Seleccione...</option>
                <option value="Hosp. Almenara">Hospital Nacional Guillermo Almenara Irigoyen</option>
                <option value="CS San Martin">Centro de Salud San Martín de Porres</option>
                <option value="Posta VES">Posta Médica Villa El Salvador</option>
                <option value="Hosp. Lima Este">Hospital Regional de Lima Este</option>
                <option value="CSM Pueblo Libre">Centro de Salud Mental Pueblo Libre</option>
            </select>
            <p class="helper-text">Información sincronizada con base de datos de SUSALUD</p>
        </div>

        <button type="submit" id="btnSubmit">REGISTRAR PARTICIPACIÓN</button>
    </form>
</div>

<script>
    const dirisOptions = [
        "DIRIS Lima Centro",
        "DIRIS Lima Este",
        "DIRIS Lima Sur",
        "DIRIS Lima Norte"
    ];

    function handleRegionChange() {
        const region = document.getElementById('region_vivienda').value;
        const selectDiris = document.getElementById('diris_diresa');
        const labelDiris = document.getElementById('diris_label');
        
        // Limpiar opciones actuales
        selectDiris.innerHTML = '<option value="">Seleccione...</option>';

        if (region === 'LIMA' || region === 'CALLAO') {
            labelDiris.innerText = "DIRIS (Lima y Callao)";
            dirisOptions.forEach(opt => {
                let el = document.createElement('option');
                el.textContent = opt;
                el.value = opt;
                selectDiris.appendChild(el);
            });
        } else if (region !== "") {
            labelDiris.innerText = "DIRESA (Región)";
            let el = document.createElement('option');
            el.textContent = "DIRESA " + region.charAt(0) + region.slice(1).toLowerCase();
            el.value = "DIRESA_" + region;
            selectDiris.appendChild(el);
        } else {
            selectDiris.innerHTML = '<option value="">Primero seleccione una región...</option>';
        }
    }

    // Validación de DNI para aceptar solo números
    document.getElementById('dni').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Manejo del envío del formulario
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        // e.preventDefault();
        
        const btn = document.getElementById('btnSubmit');
        btn.innerText = "PROCESANDO...";
        btn.style.backgroundColor = "#28a745";
        btn.disabled = true;

        setTimeout(() => {
            // alert('¡Registro exitoso! Los datos han sido enviados al sistema académico del INSN Breña.');
            // En un entorno real, aquí se enviaría la data vía Fetch API o AJAX
            btn.innerText = "REGISTRAR PARTICIPACIÓN";
            btn.style.backgroundColor = "#004a99";
            btn.disabled = false;
        }, 1500);
    });
</script>

</body>
</html>