<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('storage/icon/icon-mdlm.png') }}">

    <title>title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- TUS ESTILOS GENERALES (SIN CAMBIOS) --- */
        :root {
            --primary-color: #004a99;
            --secondary-color: #007bff;
            --dark-gray: #003366;
            --light-gray: #e7f1ff;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--light-gray);
            color: var(--dark-gray);
            line-height: 1.6;
            margin: 0;
            padding: 0;
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
            background: linear-gradient(#004a9976, #007bff78), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
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


        /* --- NUEVOS ESTILOS PARA LAS TARJETAS DE DISCIPLINA --- */
        .disciplines-section {
            padding: 3rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2.5rem;
            color: var(--dark-gray);
        }

        .disciplines-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .discipline-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: var(--dark-gray);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .discipline-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .discipline-card .card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .discipline-card .card-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
        }

        .discipline-card .card-title {
            position: absolute;
            bottom: 1rem;
            left: 1.5rem;
            color: var(--white);
            font-size: 1.8rem;
            font-weight: bold;
            z-index: 2;
        }

        .discipline-card .card-info {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .discipline-card .card-description {
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .discipline-card .card-meta {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--light-gray);
            font-size: 0.9rem;
            color: #555;
        }

        .discipline-card .card-meta span {
            margin-right: 1rem;
        }

        .main-footer {
            background-color: var(--dark-gray);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
        }

       
    </style>
</head>

<body>
    <header class="main-header">
        <div class="container" style="display:flex; justify-content:space-between">
            <a href="{{ route('index') }}" class="logo">
                <img src=""
                    alt="">
                <div class="logo-text">
                    <h1></h1>
                    <p></p>
                </div>
            </a>
            <nav> <a href="{{route('login')}}" class="hero-btn" style="display:flex;margin-right: 0; border:2px solid green">Iniciar Sesión</a></nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h2>AAAAAAAAAAAAAA</h2>
                <p>AAAAAAAAAAAAAAAAAA
                </p>
                <a href="#disciplines" class="hero-btn">Ver Cursos Disponibles</a>
            </div>
        </section>

        <section class="disciplines-section" id="disciplines">
            <div class="container">
                <h2 class="section-title">Elige un curso</h2>
                <div class="disciplines-grid">

                    {{-- Bucle sobre las disciplinas que pasas desde el controlador --}}
                    @forelse ($disciplinas as $disciplina)
                        {{-- <a href="#" class="discipline-card"> --}}


                        <a href="{{ route('talleres.show', ['disciplina' => $disciplina->id]) }}"
                            class="discipline-card">
                            <div class="card-image"
                                style="background-image: url('{{ asset('storage/' . $disciplina->imagen) }}');">
                                <h3 class="card-title">{{ $disciplina->nombre }}</h3>
                            </div>
                            <div class="card-info">
                                <p class="card-description">{{ $disciplina->descripcion_corta }}</p>
                                <div class="card-meta">
                                    <span><i class="fa-solid fa-layer-group"></i> {{ $disciplina->talleres_count }}
                                        curso</span>
                                    {{-- <span><i class="fa-solid fa-users"></i> Desde {{ $disciplina->edad_minima }}
                                        años</span> --}}
                                </div>
                            </div>
                        </a>
                    @empty
                            <p style="text-align: center; font-weight: bold">No hay Cursos Disponibles.</p>

                    @endforelse

                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; {{date('Y')}} </p>
        </div>
    </footer>
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

</body>

</html>
