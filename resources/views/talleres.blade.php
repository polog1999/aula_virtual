<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- TUS ESTILOS CSS COMPLETOS (SIN CAMBIOS) --- */
        :root {
            --primary-color: #1E8449;
            --secondary-color: #2ECC71;
            --dark-gray: #34495E;
            --light-gray: #F4F6F6;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 2rem;
            color: var(--dark-gray);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .back-link i {
            margin-right: 0.5rem;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .main-header {
            background-color: var(--white);
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .main-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--primary-color);
        }

        .logo img {
            height: 50px;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .logo-text p {
            font-size: 0.9rem;
            margin: 0;
            color: #7f8c8d;
        }

        .hero {
            background: linear-gradient(rgba(30, 132, 73, 0.8), rgba(30, 132, 73, 0.8)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
            color: var(--white);
            padding: 6rem 0;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
        }

        .hero-btn {
            background-color: var(--secondary-color);
            color: var(--dark-gray);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .hero-btn:hover {
            background-color: var(--white);
            transform: translateY(-3px);
        }

        .search-section {
            background-color: #e8f8ef;
            padding: 2rem 0;
        }

        .search-controls {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .search-controls input,
        .search-controls select {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .search-controls input {
            flex-grow: 1;
        }

        .workshops-section {
            padding: 3rem 0;
        }

        .workshops-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .workshop-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .workshop-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .workshop-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h3 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .card-category {
            background-color: var(--light-gray);
            color: var(--primary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .card-details {
            list-style: none;
            margin: 1rem 0;
        }

        .card-details li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-details i {
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }

        .card-details li a {
            text-decoration: none;
            text-align: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.85rem;
            margin-left: 0.5rem;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            background-color: var(--light-gray);
            border: 1px solid #dcdcdc;
            transition: all 0.2s ease-in-out;
        }

        .card-details li a:hover {
            background-color: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-details li i.fa-location-dot {
            margin-top: 2px;
            align-self: flex-start;
        }

        .card-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--light-gray);
        }

        .vacancies {
            font-weight: bold;
        }

        .vacancies.full {
            color: #E74C3C;
        }

        .register-btn {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.2s ease;
        }

        .register-btn:hover {
            background-color: #145A32;
        }

        .register-btn:disabled {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-content {
            background-color: var(--white);
            margin: auto;
            padding: 2.5rem;
            border-radius: 10px;
            width: 90%;
            max-width: 700px;
            position: relative;
            animation: fadeIn 0.3s;
            max-height: 95vh;
            overflow-y: auto;
        }

        .close-btn {
            color: #aaa;
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
        }

        .modal-content h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .modal-content h4 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-gray);
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            background-color: white;
        }

        /* Añadido background-color */
        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .summary-info {
            background-color: var(--light-gray);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            border: 1px dashed #ccc;
        }

        .summary-info p {
            margin: 0.5rem 0;
        }

        .summary-info strong {
            color: var(--primary-color);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #145A32;
        }

        .form-group.checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 1.5rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .inscription-type-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background-color: var(--light-gray);
            border-radius: 8px;
        }

        .inscription-type-selector label {
            flex: 1;
            padding: 0.8rem;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
            border: 1px solid #ccc;
            background-color: var(--white);
            transition: background-color 0.2s, color 0.2s;
        }

        .inscription-type-selector input[type="radio"] {
            display: none;
        }

        .inscription-type-selector input[type="radio"]:checked+label {
            background-color: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
            font-weight: bold;
        }

        .main-footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
        }

        /* --- NUEVOS ESTILOS PARA VERIFICACIÓN DE EMAIL --- */
        .email-verification-group {
            display: flex;
            gap: 0.5rem;
            align-items: flex-end;
        }

        .email-verification-group input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .send-code-btn {
            white-space: nowrap;
            padding: 0.8rem;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            background-color: var(--dark-gray);
            color: var(--white);
            border: 1px solid var(--dark-gray);
            cursor: pointer;
        }

        .verification-code-group {
            display: none;
            /* Oculto por defecto */
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .logo-text h1 {
                font-size: 1.2rem;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .search-controls {
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .workshops-grid {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .workshop-card {
                flex-direction: row;
                border-radius: 8px;
                border: 1px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }

            .workshop-card:hover {
                transform: none;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .workshop-card img {
                display: none;
            }

            .card-content {
                padding: 1rem;
            }

            .card-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding-top: 0.8rem;
            }

            .register-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container" style="display:flex; justify-content:space-between">
            <a href="{{ route('index') }}" class="logo">
                <img src=""
                    alt="Logo ">
                <div class="logo-text">
                    <h1></h1>
                    <p></p>
                </div>
            </a>
            <nav> <a href="{{ route('login') }}" class="hero-btn"
                    style="display:flex;margin-right: 0; border:2px solid green">Iniciar Sesión</a></nav>
        </div>
    </header>

    <main>
        {{-- <section class="hero">
            <div class="container">
                <h2>AAAAAAAAAAA</h2>
                <p>AAAAAAAAAAAAAA
                </p>
                <a href="#workshops" class="hero-btn">Ver Cursos Disponibles</a>
            </div>
        </section> --}}
        {{-- NUEVO: Banner específico de la disciplina --}}
        <section class="hero"
            style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('storage/' . $disciplina->imagen) }}') no-repeat center center/cover; padding: 4rem 0;">
            <div class="container">
                <h2 style="font-size: 2.5rem;">{{ $disciplina->nombre }}</h2>
                <p style="font-size: 1.1rem;">Encuentra el horario y sección perfecto para ti.</p>
            </div>
        </section>

        <section class="search-section" id="workshops">
            <div class="container">
                {{-- =============================================== --}}
                {{-- INICIO: ENLACE "VOLVER" AÑADIDO AQUÍ --}}
                {{-- =============================================== --}}
                <a href="{{ route('index') }}" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Volver a Todas los Cursos
                </a>
                {{-- =============================================== --}}
                {{-- FIN: ENLACE "VOLVER" --}}
                {{-- =============================================== --}}
                <div class="search-controls">
                    <input type="text" id="searchInput" placeholder="Buscar taller por nombre...">
                    {{-- <select id="sedeFilter">
                        <option value="todos">Todas las sedes</option>
                        @foreach ($sedes as $sede)
                            <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                        @endforeach
                    </select> --}}
                    <select id="categoryFilter">
                        <option value="todos">Todas las categorías</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">
                           {{$categoria->nombre}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        <section class="workshops-section">
            <div class="container">
                <div class="workshops-grid" id="workshopsGrid">
                    @foreach ($secciones as $seccion)
                        @php
                            $categoria = $seccion->curso->categoria;
                            // $tipo_categoria = $seccion->es_adulto;
                            // if ($categoria->tiene_discapacidad) {
                            //     $tipo_categoria = 'discapacitado';
                            // } elseif ($categoria->es_adulto) {
                            //     $tipo_categoria = 'si';
                            // } elseif (!$categoria->es_adulto && ($categoria->edad_min || $categoria->edad_max)) {
                            //     $tipo_categoria = 'no';
                            // }
                        @endphp
                        <article class="workshop-card" data-category="{{ $categoria->id }}" {{-- data-matricula-cost="{{ number_format($seccion->costo_matricula, 2) }}" --}}
                            {{-- data-mensualidad-cost="{{ number_format($seccion->talleres->costo_mensualidad, 2) }}" --}} data-id-taller="{{ $seccion->id }}"
                            {{-- data-sede="{{ $seccion->lugar_id }}"  --}}
                            {{-- data-tipo-categoria="{{ $tipo_categoria }}" --}}
                            {{-- data-es-adulto = "{{ $seccion->es_adulto }}" --}}
                             data-horario = "{{ $seccion->dia_semana }}"
                            {{-- data-frecuencia="{{ $seccion->talleres->frecuenciaVecino }}" --}}
                            >



                            {{-- <img src="{{ asset('storage/' . $seccion->talleres->disciplina->imagen) }}"
                                alt="{{ $seccion->talleres->disciplina->nombre }}"> --}}
                            <div class="card-content">
                                <span class="card-category">
                                  {{$categoria->nombre}}
                                </span>
                                <h3>{{ $seccion->curso->nombre }}</h3>
                                <ul class="card-details">
                                    <li><i class="fa-solid fa-clock"></i> {{ $seccion->periodo->anio }} -
                                        {{ $seccion->periodo->ciclo }}</li>
                                    <li><i class="fa-solid fa-calendar-days"></i> {{ $seccion->dia_semana }} -
                                        {{-- {{ strtolower($seccion->talleres->frecuencia_vecino) }} --}}
                                    </li>
                                    <li><i class="fa-solid fa-chalkboard-user"></i>
                                        {{ $seccion->docentes?->user ? $seccion->docentes->user->nombres . ' ' . $seccion->docentes->user->apellido_paterno : 'No asignado' }}
                                    </li>
                                    {{-- <li><i class="fa-solid fa-location-dot"></i> Lugar: {{ $seccion->lugares->nombre }}
                                        <a href="{{ $seccion->lugares->link_maps }}" target="_BLANK">Ver mapa</a>
                                    </li> --}}
                                </ul>
                                <div class="card-footer">
                                    <span
                                        class="vacancies {{ $seccion->matriculas_activas_count >= $seccion->vacantes ? 'full' : '' }}">Inscritos:
                                        {{ $seccion->matriculas_activas_count ?? 0 }}/{{ $seccion->vacantes ?? 0 }}</span>
                                    <button class="register-btn"
                                        {{ $seccion->matriculas_activas_count >= $seccion->vacantes ? 'disabled' : '' }}>Inscribirme</button>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} </p>
        </div>
    </footer>
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modalTitle">Formulario de Inscripción</h2>

            <div class="summary-info">
                <p>Taller: <strong><span id="selectedWorkshopName"></span></strong></p>
                <p>Horario: <strong><span id="selectedHorarioName"></span></strong></p>
                <p>Duración: <strong><span id="selectedFrecuenciaName"></span></strong></p>
                {{-- <p>Docente: <strong><span id="selectedWorkshopName"></span></strong></p> --}}
                {{-- <p>Costo Mensual: <strong> <span id="mensualidadCost">0.00</span></strong></p> --}}
            </div>

            @if ($errors->any())
                <div
                    style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>¡Ups! Revisa los siguientes errores:</strong>
                    <ul style="list-style-type: none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registrationForm" action="{{ route('talleres.preinscripcion') }}" method="POST">
                @csrf
                <input type="hidden" name="idTaller" id="idTaller">
                <input type="hidden" name="costoMensualidad" id="costoMensualidad">
                {{-- <input type="hidden" name="costoMatricula" id="costoMatricula"> --}}
                <input type="hidden" name="idCategoria" id="idCategoria">
                <input type="hidden" name="esAdulto" id="esAdulto">

                <h4 id="inscription-type-title">¿A quién vas a inscribir?</h4>
                <div class="inscription-type-selector" id="inscription-type-selector">
                    <div id="minor-option-wrapper" style="display: flex; flex: 1;">
                        <input type="radio" id="typeMinor" name="inscriptionType" value="minor">
                        <label for="typeMinor" style="width: 100%;"><i class="fa-solid fa-child"></i> A un menor de
                            edad</label>
                    </div>
                    <div id="adult-option-wrapper" style="display: flex; flex: 1;">
                        <input type="radio" id="typeAdult" name="inscriptionType" value="adult">
                        <label for="typeAdult" style="width: 100%;"><i class="fa-solid fa-user"></i> A mí mismo
                            (adulto)</label>
                    </div>
                </div>

                <div id="conadis-group" class="form-group full-width"
                    style="display: none; background-color: #fffbe6; padding: 1rem; border-radius: 8px; border: 1px solid #ffe58f; margin-top: 8px;">
                    <label for="conadisNumber" style="font-weight: bold; color: #856404;"><i
                            class="fa-solid fa-universal-access"></i> Taller para Personas con Discapacidad</label>
                    <p style="font-size: 0.9rem; margin-bottom: 0.5rem;">Por favor, ingrese el número de carnet del
                        CONADIS del participante.</p>
                    <input type="text" id="conadisNumber" name="conadis_number"
                        placeholder="Número de Carnet CONADIS">
                </div>


                <div id="parent-data-container">
                    <h4 id="parent-title">Datos del Apoderado</h4>
                    <div class="form-grid">
                        <div class="form-group"><label for="parentDNI">DNI</label><input type="text"
                                id="parentDNI" name="parentDNI" required pattern="[0-9]{8}" maxlength="8"><small
                                id="parent-helper-text"
                                style="color: var(--primary-color); height: 1em; display: block;"></small></div>
                        <div class="form-group"><label for="parentNames">Nombres</label><input type="text"
                                id="parentNames" name="parentNames" required></div>
                        <div class="form-group"><label for="parentPaternalLastName">Apellido Paterno</label><input
                                type="text" id="parentPaternalLastName" name="parentPaternalLastName" required>
                        </div>
                        <div class="form-group"><label for="parentMaternalLastName">Apellido Materno</label><input
                                type="text" id="parentMaternalLastName" name="parentMaternalLastName"></div>
                        <div class="form-group"><label for="parentPhone">Celular</label><input type="tel"
                                id="parentPhone" name="parentPhone" required pattern="[0-9]{9}" maxlength="9">
                        </div>
                        <!-- <div class="form-group"><label for="parentEmail">Email (para tu cuenta)</label><input
                                type="email" id="parentEmail" name="parentEmail"
                                required></div> -->
                        {{-- INICIO: CAMPO DE EMAIL CON VERIFICACIÓN PARA APODERADO --}}
                        <div class="form-group">
                            <label for="parentEmail">Email (para tu cuenta)</label>
                            <div class="email-verification-group">
                                <input type="email" id="parentEmail" name="parentEmail" required>
                                <button type="button" class="send-code-btn" data-target="parent">Enviar
                                    Código</button>
                            </div>
                        </div>
                        <div class="form-group verification-code-group" id="parent-code-group">
                            <label for="parentVerificationCode">Código de Verificación</label>
                            <input type="text" id="parentVerificationCode" name="parent_verification_code"
                                placeholder="Ingresa el código de 6 dígitos" maxlength="6">
                        </div>
                        {{-- FIN: CAMPO DE EMAIL CON VERIFICACIÓN --}}
                        <div class="form-group full-width"><label for="parentDireccion">Dirección</label><input
                                type="text" id="parentDireccion" name="parentDireccion"></div>

                        {{-- =============================================== --}}
                        {{-- INICIO: CAMPO DE DISTRITO PARA APODERADO --}}
                        {{-- =============================================== --}}
                        <div class="form-group full-width">
                            <label for="parentDistrito">Distrito</label>
                            <select id="parentDistrito" name="parentDistrito">
                                <option value="">Seleccione un distrito...</option>
                                {{-- @foreach ($distritos as $distrito)
                                    <option value="{{ $distrito->districodi }}">
                                        {{ $distrito->distridesc }}</option>
                                @endforeach --}}
                                {{-- <option value="999">OTRO DISTRITO FUERA DE LIMA</option> --}}
                            </select>
                            <input type="text" id="parentDistritoNombre" class="form-control" disabled
                                style="display: none;">

                            <input type="hidden" id="parentDistritoId" name="parentDistritoHidden">
                        </div>
                        {{-- =============================================== --}}
                        {{-- FIN: CAMPO DE DISTRITO --}}
                        {{-- =============================================== --}}
                    </div>
                </div>
                <div id="student-data-container">
                    <h4 id="student-title">Datos del Alumno</h4>
                    <div class="form-grid">
                        <div class="form-group"><label for="studentDNI">DNI</label><input type="text"
                                id="studentDNI" name="studentDNI" required pattern="[0-9]{8}" maxlength="8"><small
                                id="student-helper-text"
                                style="color: var(--primary-color); height: 1em; display: block;"></small></div>
                        <div class="form-group"><label for="studentNames">Nombres</label><input type="text"
                                id="studentNames" name="studentNames" required>
                        </div>
                        <div class="form-group"><label for="studentPaternalLastName">Apellido Paterno</label><input
                                type="text" id="studentPaternalLastName" name="studentPaternalLastName" required>
                        </div>
                        <div class="form-group"><label for="studentMaternalLastName">Apellido Materno</label><input
                                type="text" id="studentMaternalLastName" name="studentMaternalLastName" required>
                        </div>
                        <div class="form-group full-width"><label for="studentBirthdate">Fecha de
                                Nacimiento</label><input type="date" id="studentBirthdate" name="studentBirthdate"
                                required></div>

                        <div class="form-group full-width" id="student-extra-fields" style="display: none;">
                            <label for="studentPhone" style="margin-top:1rem;">Celular</label><input type="tel"
                                id="studentPhone" name="studentPhone" pattern="[0-9]{9}" maxlength="9">
                            <!-- <label for="studentEmail" style="margin-top:1rem;">Email (para tu cuenta)</label><input
                                type="email" id="studentEmail" name="studentEmail"
                                > -->
                            {{-- INICIO: CAMPO DE EMAIL CON VERIFICACIÓN PARA ALUMNO ADULTO --}}
                            <div class="form-group" style="margin-top: 1rem;">
                                <label for="studentEmail">Correo Electrónico (para tu cuenta)</label>
                                <div class="email-verification-group">
                                    <input type="email" id="studentEmail" name="studentEmail">
                                    <button type="button" class="send-code-btn" data-target="student">Enviar
                                        Código</button>
                                </div>
                            </div>
                            <div class="form-group verification-code-group" id="student-code-group">
                                <label for="studentVerificationCode">Código de Verificación</label>
                                <input type="text" id="studentVerificationCode" name="student_verification_code"
                                    placeholder="Ingresa el código de 6 dígitos" maxlength="6">
                            </div>
                            {{-- FIN: CAMPO DE EMAIL CON VERIFICACIÓN --}}
                            <label for="studentDireccion" style="margin-top:1rem;">Dirección</label><input
                                type="text" id="studentDireccion" name="studentDireccion">

                            {{-- =============================================== --}}
                            {{-- INICIO: CAMPO DE DISTRITO PARA ALUMNO ADULTO --}}
                            {{-- =============================================== --}}
                            <div class="form-group" style="margin-top:1rem;">
                                <label for="studentDistrito">Distrito</label>
                                <select id="studentDistrito" name="studentDistrito">
                                    <option value="">Seleccione un distrito...</option>
                                    {{-- @foreach ($distritos as $distrito)
                                        <option value="{{ $distrito->districodi }}">
                                            {{ $distrito->distridesc }}
                                        </option>
                                    @endforeach --}}
                                    {{-- <option value="999">OTRO DISTRITO FUERA DE LIMA</option> --}}
                                </select>
                                <input type="text" id="studentDistritoNombre" class="form-control" disabled
                                    style="display: none;">

                                <input type="hidden" id="studentDistritoId" name="studentDistritoHidden">
                            </div>
                            {{-- =============================================== --}}
                            {{-- FIN: CAMPO DE DISTRITO --}}
                            {{-- =============================================== --}}
                        </div>
                    </div>
                </div>


                <div class="form-group checkbox" style="align-items: center;"><input type="checkbox" id="terms"
                        name="terms" style="width: auto;" required><label for="terms" style="margin: 0;">He
                        leído y acepto los <a href="#"
                            style="
                            color: #01AC68;
                            text-decoration: underline;
                            font-weight: bold;
                            ">Términos
                            y Condiciones</a></label></div>

                <button type="submit" class="submit-btn" id="submit-inscripcion"><i class="fa-solid fa-arrow-right"></i> Continuar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        </script>
    @endif
    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: '{{ session('warning') }}'
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}'
            });
        </script>
    @endif
    @if (session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Información',
                text: '{{ session('info') }}'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- SELECTORES GLOBALES ---
            const modal = document.getElementById('registrationModal');
            const registrationForm = document.getElementById('registrationForm');
            const inscriptionTypeRadios = document.querySelectorAll('input[name="inscriptionType"]');

            // Selectores del Modal
            const inscriptionTypeSelector = document.getElementById('inscription-type-selector');
            const inscriptionTypeTitle = document.getElementById('inscription-type-title');
            const radioMinor = document.getElementById('typeMinor');
            const radioAdult = document.getElementById('typeAdult');
            const minorOptionWrapper = document.getElementById('minor-option-wrapper');
            const adultOptionWrapper = document.getElementById('adult-option-wrapper');
            const conadisGroup = document.getElementById('conadis-group');

            // Contenedores de Datos
            const parentDataContainer = document.getElementById('parent-data-container');
            const studentExtraFields = document.getElementById('student-extra-fields');
            const studentTitle = document.getElementById('student-title');

            // Inputs
            const conadisInput = document.getElementById('conadisNumber');
            const parentDNIInput = document.getElementById('parentDNI');
            const studentDNIInput = document.getElementById('studentDNI');
            const parentNamesInput = document.getElementById('parentNames');
            const parentPaternalLastNameInput = document.getElementById('parentPaternalLastName');
            const parentMaternalLastNameInput = document.getElementById('parentMaternalLastName');
            const parentDistritoInput = document.getElementById('parentDistrito');
            const studentDistritoInput = document.getElementById('studentDistrito');

            const parentPhoneInput = document.getElementById('parentPhone');
            const parentEmailInput = document.getElementById('parentEmail');
            const parentDireccionInput = document.getElementById('parentDireccion');
            const parentHelperText = document.getElementById('parent-helper-text');
            const studentNamesInput = document.getElementById('studentNames');
            const studentPaternalLastNameInput = document.getElementById('studentPaternalLastName');
            const studentMaternalLastNameInput = document.getElementById('studentMaternalLastName');
            const studentPhoneInput = document.getElementById('studentPhone');
            const studentEmailInput = document.getElementById('studentEmail');
            const studentDireccionInput = document.getElementById('studentDireccion');
            const studentHelperText = document.getElementById('student-helper-text');
            const parentDistritoNombreInput = document.getElementById('parentDistritoNombre');
            const studentDistritoIdInput = document.getElementById('studentDistritoId');
            const parentDistritoIdInput = document.getElementById('parentDistritoId');
            const studentDistritoNombreInput = document.getElementById('studentDistritoNombre');


            // --- FUNCIONES DE AYUDA ---
            function closeModal() {
                if (modal) {
                    modal.style.display = 'none';
                    registrationForm.reset();
                    resetParentFields(); // Limpia los campos del padre
                }
            }

            function toggleRequired(container, isRequired) {
                container.querySelectorAll('input, select').forEach(input => {
                    // No tocar los checkboxes
                    if (input.type !== 'checkbox') {
                        // Solo marcar como requerido si no está deshabilitado
                        input.required = isRequired && !input.disabled;
                    }
                });
            }

            function resetParentFields() {
                const fields = [parentNamesInput, parentPaternalLastNameInput, parentMaternalLastNameInput,
                    parentPhoneInput, parentEmailInput, parentDireccionInput, parentDistritoInput,
                    parentDistritoNombreInput
                ];
                fields.forEach(field => {
                    if (field) {
                        field.value = '';
                        field.removeAttribute('readonly');
                    }
                });
                //    if (parentHelperText) parentHelperText.textContent = '';
                if (studentHelperText) studentHelperText.textContent = '';

            }

            function resetStudentFields() {
                const fields = [studentNamesInput, studentPaternalLastNameInput, studentMaternalLastNameInput,
                    studentPhoneInput, studentEmailInput, studentDireccionInput, studentDistritoInput,
                    studentDistritoNombreInput
                ];
                fields.forEach(field => {
                    if (field) {
                        field.value = '';
                        field.removeAttribute('readonly');
                    }
                });
                if (parentHelperText) parentHelperText.textContent = '';
                // if (studentHelperText) studentHelperText.textContent = '';

            }

            // --- LÓGICA PRINCIPAL DE VISIBILIDAD DEL FORMULARIO ---
            const handleFormVisibility = () => {
                const selectedType = document.querySelector('input[name="inscriptionType"]:checked')?.value;

                if (selectedType === 'minor') {
                    studentTitle.textContent = 'Datos del Alumno';
                    parentDataContainer.style.display = 'block';
                    studentExtraFields.style.display = 'none';
                    toggleRequired(parentDataContainer, true);
                    toggleRequired(studentExtraFields, false);
                } else if (selectedType === 'adult') {
                    studentTitle.textContent = 'Mis Datos Personales';
                    parentDataContainer.style.display = 'none';
                    studentExtraFields.style.display = 'block';
                    toggleRequired(parentDataContainer, false);
                    toggleRequired(studentExtraFields, true);
                }
            };

            // ==========================================================
            // INICIO: NUEVA LÓGICA PARA VERIFICACIÓN DE EMAIL
            // ==========================================================
            document.querySelectorAll('.send-code-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.dataset.target; // 'student' o 'parent'
                    const emailInput = document.getElementById(`${target}Email`);
                    const codeGroup = document.getElementById(`${target}-code-group`);
                    const codeInput = document.getElementById(`${target}VerificationCode`);

                    // Simulación: Aquí iría tu llamada AJAX para enviar el correo
                    // fetch(`/api/enviar-codigo/${emailInput.value}`).then(...)
                    fetch('/enviar-codigo-verificacion', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                    .value
                            },
                            body: JSON.stringify({
                                email: emailInput.value
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            // alert("Código enviado a su correo");
                            // document.getElementById('wrapper-codigo').style.display =
                            // 'block'; // Mostramos el campo del código
                            // iniciarContador();
                        });
                    if (emailInput.value && emailInput.checkValidity()) {
                        console.log(`Simulando envío de código a: ${emailInput.value}`);

                        // Mostrar el campo del código
                        codeGroup.style.display = 'block';
                        codeInput.required = true;

                        // Cambiar texto del botón y deshabilitarlo por un tiempo
                        this.textContent = 'Reenviar Código';
                        this.disabled = true;
                        setTimeout(() => {
                            this.disabled = false;
                        }, 30000); // Re-habilitar después de 30 segundos

                        // Alerta visual para el usuario
                        Swal.fire({
                            icon: 'info',
                            title: 'Código Enviado',
                            text: `Hemos enviado un código de verificación a ${emailInput.value}. Por favor, ingrésalo en el campo correspondiente.`,
                            timer: 5000,
                            timerProgressBar: true
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Correo Inválido',
                            text: 'Por favor, ingresa una dirección de correo electrónico válida antes de enviar el código.',
                        });
                    }
                });
            });
            // ==========================================================
            // FIN: NUEVA LÓGICA
            // ==========================================================


            var inputCodigo = document.getElementById('studentVerificationCode');
            var btnContinuar =  document.getElementById('submit-inscripcion');
            // var btnEnviarCodigo = document.querySelector('.send-code-btn');

            btnContinuar.addEventListener('click', function(){
                if(inputCodigo.value == "" 
                // && btnEnviarCodigo.textContent == 'Envia Código'
            ){
                    Swal.fire({
                            icon: 'info',
                            title: 'Código de Verificación',
                            text: 'Presionel botón Enviar Código, para recibir el código de verificación en su email.',
                            timer: 10000,
                            timerProgressBar: true
                        });
            }
            });
            
            // --- EVENT LISTENERS ---
            // ABRIR MODAL
            document.querySelectorAll('.register-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    // 0. Resetear el formulario a su estado original
                    // registrationForm.reset();
                    resetParentFields();

                    const card = e.target.closest('.workshop-card');

                    // 1. Llenar datos del taller en el modal
                    document.getElementById('modalTitle').textContent =
                        `Inscripción para: ${card.querySelector('h3').textContent}`;
                    document.getElementById('selectedWorkshopName').textContent = card
                        .querySelector('h3').textContent;
                    document.getElementById('selectedHorarioName').textContent = card.dataset
                        .horario;
                    //document.getElementById('selectedFrecuenciaName').textContent = card.dataset
                        //.frecuencia.toLowerCase();
                    /* document.getElementById('mensualidadCost').textContent = card.dataset
                         .mensualidadCost == 0 ? 'GRATUITO' : 'S/ ' + card.dataset
                         .mensualidadCost;*/
                    document.getElementById('idTaller').value = card.dataset.idTaller;
                    document.getElementById('idCategoria').value = card.dataset.category;
                    document.getElementById('costoMensualidad').value = card.dataset
                        .mensualidadCost;

                    const tipoCategoria = card.dataset.tipoCategoria;

                    // 2. Resetear la visibilidad del selector
                    inscriptionTypeSelector.style.display = 'flex';
                    inscriptionTypeTitle.style.display = 'block';
                    minorOptionWrapper.style.display = 'flex';
                    adultOptionWrapper.style.display = 'flex';
                    conadisGroup.style.display = 'none';
                    conadisInput.required = false;

                    // 3. Adaptar el formulario según el tipo de categoría
                    if (tipoCategoria === 'discapacitado') {
                        conadisGroup.style.display = 'block';
                        conadisInput.required = true;
                        radioMinor.checked = true;
                    } else if (tipoCategoria === 'si') { // Solo Adulto
                        minorOptionWrapper.style.display = 'none';
                        radioAdult.checked = true;
                    } else if (tipoCategoria === 'no') { // Solo Menor
                        adultOptionWrapper.style.display = 'none';
                        radioMinor.checked = true;
                    } else { // 'todos'
                        radioMinor.checked = true;
                    }

                    // 4. Ejecutar la lógica de visibilidad para mostrar/ocultar campos
                    handleFormVisibility();
                    modal.style.display = 'flex';
                });
            });

            // CERRAR MODAL
            modal.querySelector('.close-btn').addEventListener('click', closeModal);
            let mouseDownInside = false;
            modal.querySelector('.modal-content').addEventListener('mousedown', () => {
                mouseDownInside = true;
            });
            modal.addEventListener('mouseup', (e) => {
                if (!mouseDownInside && e.target === modal) closeModal();
                mouseDownInside = false;
            });

            // CAMBIOS EN RADIOS
            document.querySelectorAll('input[name="inscriptionType"]').forEach(radio => radio.addEventListener(
                'change', handleFormVisibility));

            // BÚSQUEDA POR DNI DEL APODERADO
            parentDNIInput.addEventListener('input', buscarPorDniApoderado);
            studentDNIInput.addEventListener('input', buscarPorDniAlumno);

            // // 1. Ejecutar si el DNI ya viene lleno (cuando falla la validación)
            // if (parentDNIInput.value.length === 8) {
            //     // Usamos .call para que el "this" dentro de la función sea el input
            //     buscarPorDniApoderado.call(parentDNIInput);
            // }
            // // Función para disparar la búsqueda manualmente
            // function dispararBusquedaDNI() {
            //     const parentDNIInput = document.getElementById('parentDNI'); // Verifica el ID
            //     if (parentDNIInput && parentDNIInput.value.length === 8) {
            //         // Disparamos el evento input manualmente
            //         parentDNIInput.dispatchEvent(new Event('input'));
            //     }
            // }

            // // Ejecutar cuando el DOM esté listo
            // if (document.readyState === 'loading') {
            //     document.addEventListener('DOMContentLoaded', dispararBusquedaDNI);
            // } else {
            //     dispararBusquedaDNI();
            // }

            function buscarPorDniApoderado() {
                const dni = this.value;
                if (dni.length < 8) {
                    resetParentFields();
                    parentDNIInput.value = dni;
                    parentHelperText.textContent = '';
                    return;
                }

                if (dni.length === 8) {
                    // Evitar buscar si los campos ya están llenos y tienen readonly 
                    // (Esto indica que la búsqueda ya se hizo con éxito antes)
                    if (parentNamesInput.value !== '' && parentNamesInput.hasAttribute('readonly')) {
                        return;
                    }
                    parentHelperText.textContent = 'Buscando...';
                    fetch(`/verificar-por-dni/${dni}`)
                        .then(response => response.ok ? response.json() : Promise.reject('Error de red'))
                        .then(data => {
                            const selectedType = document.querySelector('input[name="inscriptionType"]:checked')
                                ?.value;
                            var inputs = null;

                            inputs = {
                                nombre: parentNamesInput,
                                paterno: parentPaternalLastNameInput,
                                materno: parentMaternalLastNameInput,
                                // celular: parentPhoneInput,
                                direccion: parentDireccionInput
                            };
                            console.log(data['nombre']);


                            if (data['codResu'] == '0000') {
                                console.log('si es 0000');
                                parentHelperText.textContent = '✓ Cuenta encontrada. Datos cargados.';
                                Object.keys(inputs).forEach(key => {
                                    if (inputs[key] && data[key]) {
                                        inputs[key].value = data[key];
                                        inputs[key].setAttribute('readonly', true);
                                    }
                                });
                                //HACER VISIBLE EL INPUT DE DISTRITO
                                parentDistritoNombreInput.value = data['nombreDist'];
                                parentDistritoNombreInput.style.display = 'block';

                                //HACER NO VISIBLE EL SELECT DISTRITO
                                parentDistritoInput.style.display = 'none';
                                parentDistritoInput.setAttribute('disabled', true);

                                parentDistritoIdInput.value = data['codigoDist'];




                            } else {
                                console.log('No es 0000');
                                parentHelperText.textContent =
                                    'DNI no registrado. Por favor, completa tus datos.';
                                resetParentFields();
                                parentDNIInput.value = dni;

                                //HACER VISIBLE EL SELECT DISTRITO
                                parentDistritoInput.style.display = 'block';
                                parentDistritoInput.removeAttribute('disabled');
                                parentDistritoInput.value = '';

                                parentDistritoNombreInput.style.display = 'none';
                                parentDistritoIdInput.value = '';

                                fetch(`/verificar-por-dni-local/${dni}`)
                                    .then(response => response.ok ? response.json() : Promise.reject(
                                        'Error de red'))
                                    .then(data => {
                                        const selectedType = document.querySelector(
                                                'input[name="inscriptionType"]:checked')
                                            ?.value;
                                        var inputs = null;

                                        inputs = {
                                            nombres: parentNamesInput,
                                            apellido_paterno: parentPaternalLastNameInput,
                                            apellido_materno: parentMaternalLastNameInput,
                                            celular: parentPhoneInput,
                                            direccion: parentDireccionInput
                                        };
                                        console.log(data['nombre']);


                                        if (data.encontrado) {
                                            console.log('si es 0000');
                                            parentHelperText.textContent =
                                                '✓ Cuenta encontrada. Datos cargados.';
                                            Object.keys(inputs).forEach(key => {
                                                if (inputs[key] && data.usuario[key]) {
                                                    inputs[key].value = data.usuario[key];
                                                    inputs[key].setAttribute('readonly', true);
                                                }
                                            });
                                            //HACER VISIBLE EL INPUT DE DISTRITO
                                            parentDistritoNombreInput.value = data.usuario['distrito'];
                                            parentDistritoNombreInput.style.display = 'block';

                                            //HACER NO VISIBLE EL SELECT DISTRITO
                                            parentDistritoInput.style.display = 'none';
                                            parentDistritoInput.setAttribute('disabled', true);

                                            parentDistritoIdInput.value = data.usuario['codigo_distrito'];




                                        } else {
                                            console.log('No es 0000');
                                            parentHelperText.textContent =
                                                'DNI no registrado. Por favor, completa tus datos.';
                                            resetParentFields();
                                            parentDNIInput.value = dni;

                                            //HACER VISIBLE EL SELECT DISTRITO
                                            parentDistritoInput.style.display = 'block';
                                            parentDistritoInput.removeAttribute('disabled');
                                            parentDistritoInput.value = '';

                                            parentDistritoNombreInput.style.display = 'none';
                                            parentDistritoIdInput.value = '';




                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al verificar DNI:', error);
                                        parentHelperText.textContent = 'No se pudo verificar el DNI.';
                                    });





                            }
                        })
                        .catch(error => {
                            console.error('Error al verificar DNI:', error);
                            parentHelperText.textContent = 'No se pudo verificar el DNI.';
                        });
                }
            }


            function buscarPorDniAlumno() {
                const dni = this.value;
                if (dni.length < 8) {
                    resetStudentFields();
                    studentDNIInput.value = dni;
                    studentHelperText.textContent = '';
                    return;
                }
                if (dni.length === 8) {
                    studentHelperText.textContent = 'Buscando...';
                    fetch(`/verificar-por-dni/${dni}`)
                        .then(response => response.ok ? response.json() : Promise.reject('Error de red'))
                        .then(data => {
                            const selectedType = document.querySelector('input[name="inscriptionType"]:checked')
                                ?.value;
                            var inputs = null;

                            inputs = {
                                nombre: studentNamesInput,
                                paterno: studentPaternalLastNameInput,
                                materno: studentMaternalLastNameInput,
                                // celular: studentPhoneInput,
                                // email: studentEmailInput,
                                // ubigeo: studentDistrito,
                                direccion: studentDireccionInput
                            };


                            if (data['codResu'] == '0000') {
                                studentHelperText.textContent = '✓ Cuenta encontrada. Datos cargados.';
                                Object.keys(inputs).forEach(key => {
                                    if (inputs[key] && data[key]) {
                                        inputs[key].value = data[key];
                                        inputs[key].setAttribute('readonly', true);
                                    }
                                });
                                //HACER VISIBLE EL INPUT DE DISTRITO
                                studentDistritoNombreInput.value = data['nombreDist'];
                                studentDistritoNombreInput.style.display = 'block';

                                //HACER NO VISIBLE EL SELECT DISTRITO
                                studentDistritoInput.style.display = 'none';
                                studentDistritoInput.setAttribute('disabled', true);

                                studentDistritoIdInput.value = data['codigoDist'];
                            } else {
                                studentHelperText.textContent =
                                    'DNI no registrado. Por favor, completa tus datos.';
                                resetStudentFields();
                                studentDNIInput.value = dni;

                                //HACER VISIBLE EL SELECT DISTRITO
                                studentDistritoInput.style.display = 'block';
                                studentDistritoInput.removeAttribute('disabled');
                                studentDistritoInput.value = '';

                                studentDistritoNombreInput.style.display = 'none';
                                studentDistritoIdInput.value = '';
                                fetch(`/verificar-por-dni-local/${dni}`)
                                    .then(response => response.ok ? response.json() : Promise.reject(
                                        'Error de red'))
                                    .then(data => {
                                        const selectedType = document.querySelector(
                                                'input[name="inscriptionType"]:checked')
                                            ?.value;
                                        var inputs = null;

                                        inputs = {
                                            nombres: studentNamesInput,
                                            apellido_paterno: studentPaternalLastNameInput,
                                            apellido_materno: studentMaternalLastNameInput,
                                            celular: studentPhoneInput,
                                            email: studentEmailInput,
                                            // distrito: studentDistrito,
                                            direccion: studentDireccionInput
                                        };


                                        if (data.encontrado) {
                                            studentHelperText.textContent =
                                                '✓ Cuenta encontrada. Datos cargados.';
                                            Object.keys(inputs).forEach(key => {
                                                if (inputs[key] && data.usuario[key]) {
                                                    inputs[key].value = data.usuario[key];
                                                    inputs[key].setAttribute('readonly', true);
                                                }
                                            });
                                            //HACER VISIBLE EL INPUT DE DISTRITO
                                            studentDistritoNombreInput.value = data.usuario['distrito'];
                                            studentDistritoNombreInput.style.display = 'block';

                                            //HACER NO VISIBLE EL SELECT DISTRITO
                                            studentDistritoInput.style.display = 'none';
                                            studentDistritoInput.setAttribute('disabled', true);

                                            studentDistritoIdInput.value = data.usuario['codigo_distrito'];
                                        } else {
                                            studentHelperText.textContent =
                                                'DNI no registrado. Por favor, completa tus datos.';
                                            resetStudentFields();
                                            studentDNIInput.value = dni;

                                            //HACER VISIBLE EL SELECT DISTRITO
                                            studentDistritoInput.style.display = 'block';
                                            studentDistritoInput.removeAttribute('disabled');
                                            studentDistritoInput.value = '';

                                            studentDistritoNombreInput.style.display = 'none';
                                            studentDistritoIdInput.value = '';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al verificar DNI:', error);
                                        studentHelperText.textContent = 'No se pudo verificar el DNI.';
                                    });

                            }
                        })
                        .catch(error => {
                            console.error('Error al verificar DNI:', error);
                            studentHelperText.textContent = 'No se pudo verificar el DNI.';
                        });
                }
            }
            // LÓGICA DE FILTRADO DE TALLERES
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const sedeFilter = document.getElementById('sedeFilter');
            const allCards = document.querySelectorAll('.workshop-card');

            function filterWorkshops() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                const selectedSede = sedeFilter.value;
                allCards.forEach(card => {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const category = card.dataset.category;
                    const sede = card.dataset.sede;
                    const matchesSearch = title.includes(searchTerm);
                    const matchesCategory = (selectedCategory === 'todos' || category == selectedCategory);
                    const matchesSede = (selectedSede === 'todos' || sede == selectedSede);
                    card.style.display = (matchesSearch && matchesCategory && matchesSede) ? 'flex' :
                        'none';
                });
            }
            searchInput.addEventListener('input', filterWorkshops);
            categoryFilter.addEventListener('change', filterWorkshops);
            sedeFilter.addEventListener('change', filterWorkshops);
        });
    </script>
</body>

</html>
