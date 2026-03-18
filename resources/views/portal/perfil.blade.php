{{-- @extends(auth()->user()->role->value == 'ADMIN' ? 'layouts.admin.app' : (auth()->user()->role->value == 'ENCARGADO_SEDE' ? 'layouts.encargadoSede.app' : (auth()->user()->role->value == 'PADRE' ? 'layouts.apoderado.app' : (auth()->user()->role->value == 'DOCENTE' ? 'layouts.docente.app':'layouts.alumno.app')))) --}}
@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        /* === ESTILOS GENERALES === */
        .content {
            padding: 2rem;
        }

        /* === TARJETA DE PERFIL === */
        .profile-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .text-danger {
            color: #dc3545;
            /* Código de color rojo estándar para Bootstrap/peligro */
        }

        .profile-header-bg {
            background: linear-gradient(135deg, #92a8b9, var(--dark-gray));
            height: 120px;
            position: relative;
        }

        .profile-avatar-container {
            position: absolute;
            bottom: -40px;
            left: 40px;
            width: 100px;
            height: 100px;
            background: #fff;
            border-radius: 50%;
            padding: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-icon {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #f1f2f6;
            color: var(--dark-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .profile-body {
            padding: 50px 40px 40px 40px;
        }

        .profile-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .user-name {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
        }

        .user-role {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Grid de Datos */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-group {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color, #1E8449);
        }

        .info-group label {
            display: block;
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-bottom: 0.3rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-group span {
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 500;
        }

        /* Botones */
        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color, #1E8449);
            color: white;
        }

        .btn-primary:hover {
            background-color: #145a32;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d35400;
        }

        /* === MODALES (Estilo consistente) === */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: flex-start;
            padding: 2rem;
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
            color: var(--primary-color, #1E8449);
        }

        .close-icon {
            font-size: 1.5rem;
            cursor: pointer;
            color: #aaa;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: var(--primary-color, #1E8449);
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 132, 73, 0.1);
        }

        .modal-footer {
            text-align: right;
            margin-top: 1.5rem;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 600px) {
            .profile-body {
                padding: 50px 20px 20px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('title', 'Mi Perfil')

@section('content')
    <div class="content">

        <div class="profile-card">

            <!-- Encabezado Visual -->
            <div class="profile-header-bg">
                <div class="profile-avatar-container">
                    <div class="avatar-icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del Perfil -->
            <div class="profile-body">

                <!-- Título y Rol -->
                <div class="profile-title">
                    <div>
                        <h1 class="user-name">
                            {{ Auth::user()->nombres }} {{ Auth::user()->apellido_paterno }}
                        </h1>
                        <span class="user-role">
                            <i class="fas fa-id-badge"></i> {{ Auth::user()->getRoleNames()->first() }}
                        </span>
                    </div>

                    <!-- Botón para cambiar contraseña -->
                    <button class="btn btn-warning" id="btnChangePassword">
                        <i class="fas fa-key"></i> Cambiar Contraseña
                    </button>
                </div>
                {{-- Mensaje de éxito --}}
                @if (session('status') == 'password-updated')
                    <div class="alert alert-success"
                        style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <i class="fa-solid fa-circle-check"></i> Contraseña actualizada correctamente.
                    </div>
                @endif
                  @if ($errors->updatePassword->any())
                <div class="alert alert-danger"
                    style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 2rem;">

                <!-- Grilla de Información -->
                <div class="info-grid">
                    <div class="info-group">
                        <label>Nombre Completo</label>
                        <span>{{ Auth::user()->nombres }} {{ Auth::user()->apellido_paterno }}
                            {{ Auth::user()->apellido_materno }}</span>
                    </div>

                    <div class="info-group">
                        <label>Correo Electrónico</label>
                        <span>{{ Auth::user()->email }}</span>
                    </div>

                    <div class="info-group">
                        <label>Documento de Identidad</label>
                        <span>{{ Auth::user()->tipo_documento }}: {{ Auth::user()->numero_documento }}</span>
                    </div>

                    <div class="info-group">
                        <label>Fecha de Nacimiento</label>
                        <span>
                            {{ Auth::user()->fecha_nacimiento ? \Carbon\Carbon::parse(Auth::user()->fecha_nacimiento)->format('d/m/Y') : 'No registrado' }}
                        </span>
                    </div>

                    <div class="info-group">
                        <label>Estado de la Cuenta</label>
                        <span
                            style="color: {{ Auth::user()->activo == 'ACTIVO' || Auth::user()->activo == 1 ? '#2ecc71' : '#e74c3c' }}">
                            {{ Auth::user()->activo == 'ACTIVO' || Auth::user()->activo == 1 ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </div>

                    <div class="info-group">
                        <label>Fecha de Registro</label>
                        {{-- <span>{{ Auth::user()->created_at->format('d/m/Y') }}</span> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- ============================================= -->
    <!-- ========= MODAL CAMBIAR CONTRASEÑA ========== -->
    <!-- ============================================= -->
    <div id="passwordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-lock"></i> Cambiar Contraseña</h2>
                <span class="close-icon">&times;</span>
            </div>
            {{-- Mostrar errores (ej. si la contraseña actual es incorrecta) --}}
          
            {{-- Asegúrate de tener la ruta 'profile.updatePassword' o similar definida en web.php --}}
            <form
                action="
            {{ Route::has('user-password.update') ? route('user-password.update') : '#' }}
             "
                method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password">Contraseña Actual</label>
                        <input type="password" id="current_password" name="current_password" required
                            placeholder="Ingrese su contraseña actual" minlength="8">
                    </div>

                    <hr style="border: 0; border-top: 1px dashed #ddd; margin: 1.5rem 0;">

                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña</label>
                        <input type="password" id="password" name="password" required minlength="8"
                            placeholder="Mínimo 8 caracteres">
                    </div>
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                        <input type="password" id="assword_confirmation" name="password_confirmation" minlength="8"
                            required placeholder="Repita la nueva contraseña">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('passwordModal');
            const btnOpen = document.getElementById('btnChangePassword');
            const closeElements = document.querySelectorAll('.close-icon, .cancel-btn');

            // Abrir Modal
            btnOpen?.addEventListener('click', () => {
                modal.style.display = 'flex';
                // Resetear form al abrir si se desea
                modal.querySelector('form').reset();
            });

            // Cerrar Modal (Botones)
            closeElements.forEach(el => {
                el.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            });

            // Cerrar al hacer clic fuera
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
@endpush
