<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
      
        :root {
            --primary-color: #1E8449; --secondary-color: #2ECC71; --dark-gray: #34495E;
            --light-gray: #F4F6F6; --white: #ffffff; --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--light-gray); color: var(--dark-gray); line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        .main-header { background-color: var(--white); padding: 1rem 0; box-shadow: var(--shadow); position: sticky; top: 0; z-index: 100; }
        .main-header .container { display: flex; align-items: center; justify-content: space-between; }
        .logo { display: flex; align-items: center; gap: 15px; text-decoration: none; color: var(--primary-color); }
        .logo img { height: 50px; }
        .logo-text h1 { font-size: 1.5rem; margin: 0; }
        .logo-text p { font-size: 0.9rem; margin: 0; color: #7f8c8d; }
        .hero { background: linear-gradient(rgba(30, 132, 73, 0.8), rgba(30, 132, 73, 0.8)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover; color: var(--white); padding: 6rem 0; text-align: center; }
        .hero h2 { font-size: 2.8rem; margin-bottom: 1rem; font-weight: 700; }
        .hero p { font-size: 1.2rem; max-width: 600px; margin: 0 auto 2rem auto; }
        .hero-btn { background-color: var(--secondary-color); color: var(--dark-gray); padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: bold; transition: transform 0.2s ease, background-color 0.2s ease; }
        .hero-btn:hover { background-color: var(--white); transform: translateY(-3px); }
        .search-section { background-color: #e8f8ef; padding: 2rem 0; }
        .search-controls { display: flex; gap: 1.5rem; flex-wrap: wrap; }
        .search-controls input, .search-controls select { padding: 0.8rem; border: 1px solid #ccc; border-radius: 8px; font-size: 1rem; }
        .search-controls input { flex-grow: 1; }
        .workshops-section { padding: 3rem 0; }
        .workshops-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; }
        .workshop-card { background-color: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .workshop-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); }
        .workshop-card img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        .card-content h3 { color: var(--primary-color); margin-bottom: 0.5rem; }
        .card-category { background-color: var(--light-gray); color: var(--primary-color); padding: 0.2rem 0.6rem; border-radius: 5px; font-size: 0.8rem; font-weight: bold; display: inline-block; margin-bottom: 1rem; }
        .card-details { list-style: none; margin: 1rem 0; }
        .card-details li { margin-bottom: 0.5rem; display: flex; align-items: center; gap: 10px; }
        .card-details i { color: var(--primary-color); width: 20px; text-align: center; }
        .card-details li a { text-decoration: none; text-align: center; color: var(--primary-color); font-weight: 600; font-size: 0.85rem; margin-left: 0.5rem; padding: 0.2rem 0.6rem; border-radius: 4px; background-color: var(--light-gray); border: 1px solid #dcdcdc; transition: all 0.2s ease-in-out; }
        .card-details li a:hover { background-color: var(--primary-color); color: var(--white); border-color: var(--primary-color); transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .card-details li i.fa-location-dot { margin-top: 2px; align-self: flex-start; }
        .card-footer { margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid var(--light-gray); }
        .vacancies { font-weight: bold; }
        .vacancies.full { color: #E74C3C; }
        .register-btn { background-color: var(--primary-color); color: var(--white); padding: 0.6rem 1.2rem; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem; transition: background-color 0.2s ease; }
        .register-btn:hover { background-color: #145A32; }
        .register-btn:disabled { background-color: #95a5a6; cursor: not-allowed; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.6); align-items: center; justify-content: center; padding: 1rem; }
        .modal-content { background-color: var(--white); margin: auto; padding: 2.5rem; border-radius: 10px; width: 90%; max-width: 700px; position: relative; animation: fadeIn 0.3s; max-height: 95vh; overflow-y: auto; }
        .close-btn { color: #aaa; position: absolute; top: 1rem; right: 1.5rem; font-size: 2rem; font-weight: bold; cursor: pointer; }
        .close-btn:hover, .close-btn:focus { color: black; }
        .modal-content h2 { color: var(--primary-color); margin-bottom: 1rem; }
        .modal-content h4 { margin-top: 1.5rem; margin-bottom: 1rem; color: var(--dark-gray); border-bottom: 1px solid var(--light-gray); padding-bottom: 0.5rem; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 0; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; font-size: 0.95rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; background-color: white; }
        .form-group.full-width { grid-column: 1 / -1; }
        .summary-info { background-color: var(--light-gray); padding: 1rem; border-radius: 8px; margin-top: 1.5rem; border: 1px dashed #ccc; }
        .summary-info p { margin: 0.5rem 0; }
        .summary-info strong { color: var(--primary-color); }
        .submit-btn { width: 100%; padding: 1rem; background-color: var(--primary-color); color: var(--white); border: none; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; margin-top: 1.5rem; transition: background-color 0.2s; }
        .submit-btn:hover { background-color: #145A32; }
        .form-group.checkbox { display: flex; align-items: center; gap: 10px; margin-top: 1.5rem; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        .inscription-type-selector { display: flex; gap: 1rem; margin-bottom: 1.5rem; padding: 0.5rem; background-color: var(--light-gray); border-radius: 8px; }
        .inscription-type-selector label { flex: 1; padding: 0.8rem; text-align: center; border-radius: 6px; cursor: pointer; border: 1px solid #ccc; background-color: var(--white); transition: background-color 0.2s, color 0.2s; }
        .inscription-type-selector input[type="radio"] { display: none; }
        .inscription-type-selector input[type="radio"]:checked+label { background-color: var(--primary-color); color: var(--white); border-color: var(--primary-color); font-weight: bold; }
        .main-footer { background-color: var(--dark-gray); color: var(--white); padding: 2rem 0; text-align: center; }
        
        /* --- NUEVOS ESTILOS PARA VERIFICACIÓN DE EMAIL --- */
        .email-verification-group { display: flex; gap: 0.5rem; align-items: flex-end; }
        .email-verification-group input { border-top-right-radius: 0; border-bottom-right-radius: 0; }
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
            display: none; /* Oculto por defecto */
            margin-top: 1rem;
        }
        
        @media (max-width: 768px) {
            /* ... tus media queries existentes ... */
        }
    </style>
</head>
<body>
    <header class="main-header"><!-- ... TU HEADER ... --></header>
    <main><!-- ... TUS SECCIONES HERO, SEARCH Y WORKSHOPS ... --></main>
    <footer class="main-footer"><!-- ... TU FOOTER ... --></footer>

    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modalTitle">Formulario de Inscripción</h2>
            <div class="summary-info"><!-- ... --></div>

            <form id="registrationForm" action="{{ route('talleres.preinscripcion') }}" method="POST">
                @csrf
                <input type="hidden" name="idTaller" id="idTaller">
                <input type="hidden" name="costoMensualidad" id="costoMensualidad">

                <h4 id="inscription-type-title">¿A quién vas a inscribir?</h4>
                <div class="inscription-type-selector" id="inscription-type-selector"><!-- ... --></div>
                <div id="conadis-group" class="form-group full-width" style="display: none;"><!-- ... --></div>

                <div id="student-data-container">
                    <h4 id="student-title">Datos del Alumno</h4>
                    <div class="form-grid">
                        {{-- ... campos de DNI, Nombres, Apellidos, Fecha Nacimiento del alumno ... --}}
                        <div class="form-group full-width" id="student-extra-fields" style="display: none;">
                            {{-- ... campos de celular y dirección del alumno adulto ... --}}
                            
                            {{-- INICIO: CAMPO DE EMAIL CON VERIFICACIÓN PARA ALUMNO ADULTO --}}
                            <div class="form-group" style="margin-top: 1rem;">
                                <label for="studentEmail">Correo Electrónico (para tu cuenta)</label>
                                <div class="email-verification-group">
                                    <input type="email" id="studentEmail" name="studentEmail">
                                    <button type="button" class="send-code-btn" data-target="student">Enviar Código</button>
                                </div>
                            </div>
                            <div class="form-group verification-code-group" id="student-code-group">
                                <label for="studentVerificationCode">Código de Verificación</label>
                                <input type="text" id="studentVerificationCode" name="student_verification_code" placeholder="Ingresa el código de 6 dígitos">
                            </div>
                            {{-- FIN: CAMPO DE EMAIL CON VERIFICACIÓN --}}

                            {{-- ... campo de distrito del alumno adulto ... --}}
                        </div>
                    </div>
                </div>

                <div id="parent-data-container">
                    <h4 id="parent-title">Datos del Apoderado</h4>
                    <div class="form-grid">
                        {{-- ... campos de DNI, Nombres, Apellidos, Celular del apoderado ... --}}
                        
                        {{-- INICIO: CAMPO DE EMAIL CON VERIFICACIÓN PARA APODERADO --}}
                        <div class="form-group">
                            <label for="parentEmail">Email (para tu cuenta)</label>
                            <div class="email-verification-group">
                                <input type="email" id="parentEmail" name="parentEmail" required>
                                <button type="button" class="send-code-btn" data-target="parent">Enviar Código</button>
                            </div>
                        </div>
                        <div class="form-group verification-code-group" id="parent-code-group">
                            <label for="parentVerificationCode">Código de Verificación</label>
                            <input type="text" id="parentVerificationCode" name="parent_verification_code" placeholder="Ingresa el código de 6 dígitos">
                        </div>
                        {{-- FIN: CAMPO DE EMAIL CON VERIFICACIÓN --}}

                        {{-- ... campos de dirección y distrito del apoderado ... --}}
                    </div>
                </div>

                <div class="form-group checkbox"><input type="checkbox" id="terms" name="terms" required><label for="terms">Acepto los términos y condiciones.</label></div>
                <button type="submit" class="submit-btn"><i class="fa-solid fa-arrow-right"></i> Continuar</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Tu código para mostrar alertas de sesión (success, error, info) va aquí --}}

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- TUS SELECTORES Y FUNCIONES DE AYUDA EXISTENTES ---
        const modal = document.getElementById('registrationModal');
        // ... (resto de tus selectores sin cambios)

        // --- FUNCIONES DE AYUDA ---
        function closeModal() { /* ... */ }
        function toggleRequired(container, isRequired) { /* ... */ }
        function resetParentFields() { /* ... */ }
        
        // --- LÓGICA PRINCIPAL DE VISIBILIDAD DEL FORMULARIO ---
        const handleFormVisibility = () => { /* ... (tu lógica existente sin cambios) ... */ };

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

        // --- TUS EVENT LISTENERS EXISTENTES (SIN CAMBIOS) ---
        // ABRIR MODAL
        document.querySelectorAll('.register-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                // ... tu lógica para abrir el modal ...
            });
        });
        
        // CERRAR MODAL, CAMBIOS EN RADIOS, BÚSQUEDA POR DNI, FILTRADO...
        // ... (todo tu código existente va aquí sin modificaciones)
    });
    </script>
</body>
</html>