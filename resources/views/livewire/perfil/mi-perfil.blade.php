
@php
    // BUSCAMOS LOS ERRORES EN LA SESIÓN Y EN EL OBJETO ERRORS
    $errorBag = session('errors') ? session('errors')->getBag('updatePassword') : $errors->getBag('updatePassword');
    $hasErrors = $errorBag->any();
@endphp

{{-- TODO DEBE ESTAR DENTRO DE ESTE DIV ÚNICO --}}
<div class="p-4 md:p-8" 
     x-data="{ modalOpen: false }" 
     x-init="if ({{ $hasErrors ? 'true' : 'false' }}) { modalOpen = true }">
    
    @section('vista', 'Mi Perfil')

    <div class="max-w-4xl mx-auto">
        
        {{-- BLOQUE DE ERRORES ROJO --}}
        @if ($hasErrors)
            <div class="bg-red-50 border-l-8 border-red-600 p-5 rounded-2xl mb-8 shadow-xl animate-in slide-in-from-top-4 duration-500">
                <div class="flex items-center gap-4">
                    <div class="bg-red-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-exclamation-circle text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-red-900 uppercase tracking-tighter">No se pudo actualizar la contraseña</h3>
                        <p class="text-sm text-red-700 font-bold italic uppercase tracking-tighter">Verifica los errores en el formulario.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- TARJETA DE PERFIL --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 overflow-hidden border border-slate-100">
            <div class="h-32 bg-gradient-to-r from-slate-400 to-slate-700 relative">
                <div class="absolute -bottom-12 left-8 md:left-12">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white rounded-full p-1.5 shadow-xl">
                        <div class="w-full h-full bg-slate-100 rounded-full flex items-center justify-center text-slate-400 text-4xl md:text-5xl">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-16 pb-8 px-8 md:px-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight">
                            {{ $user->nombres }} {{ $user->apellido_paterno }}
                        </h1>
                        <p class="flex items-center gap-2 text-blue-600 font-bold uppercase text-xs tracking-widest mt-1">
                            <i class="fas fa-id-badge text-lg"></i>
                            {{ $user->getRoleNames()->first() ?? 'Usuario' }}
                        </p>
                    </div>
                    
                    <button @click="modalOpen = true" class="flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-amber-100 transition-all active:scale-95">
                        <i class="fas fa-key"></i> CAMBIAR CONTRASEÑA
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-perfil-info-box label="Nombre Completo" icon="fa-user">
                        {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}
                    </x-perfil-info-box>

                    <x-perfil-info-box label="Correo Electrónico" icon="fa-envelope">
                        {{ $user->email }}
                    </x-perfil-info-box>

                    <x-perfil-info-box label="Documento de Identidad" icon="fa-id-card">
                        {{ $user->tipo_documento }}: {{ $user->numero_documento }}
                    </x-perfil-info-box>

                    <x-perfil-info-box label="Fecha de Nacimiento" icon="fa-cake-candles">
                        {{ $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : 'No registrado' }}
                    </x-perfil-info-box>

                    <x-perfil-info-box label="Estado de la Cuenta" icon="fa-circle-check">
                        <span class="{{ $user->activo ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->activo ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </x-perfil-info-box>

                    <x-perfil-info-box label="Miembro desde" icon="fa-calendar-check">
                        {{ $user->created_at->format('d/m/Y') }}
                    </x-perfil-info-box>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL (DENTRO DEL DIV RAÍZ) --}}
    <div x-show="modalOpen" 
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-md"
         style="display: none;"
         x-cloak>
        
        <div @click.away="modalOpen = false" class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 bg-slate-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold uppercase tracking-widest flex items-center gap-2"><i class="fas fa-lock text-amber-400"></i> Seguridad</h2>
                <button @click="modalOpen = false" class="text-slate-400 hover:text-white text-3xl">&times;</button>
            </div>
            
            <form action="{{ route('user-password.update') }}" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Contraseña Actual</label>
                    <input type="password" name="current_password" required 
                        class="w-full border-2 rounded-2xl p-3.5 focus:border-blue-500 outline-none font-bold {{ $errorBag->has('current_password') ? 'border-red-500 bg-red-50' : 'border-slate-100 bg-slate-50' }}">
                    @if($errorBag->has('current_password'))
                        <div class="text-red-600 text-[10px] font-black mt-2 bg-red-50 p-2 rounded-lg border border-red-100 uppercase italic">
                            {{ $errorBag->first('current_password') }}
                        </div>
                    @endif
                </div>

                <div class="h-px bg-slate-100 my-2"></div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Nueva Contraseña</label>
                    <input type="password" name="password" required 
                        class="w-full border-2 rounded-2xl p-3.5 focus:border-blue-500 outline-none font-bold {{ $errorBag->has('password') ? 'border-red-500 bg-red-50' : 'border-slate-100 bg-slate-50' }}">
                    @if($errorBag->has('password'))
                        <div class="text-red-600 text-[10px] font-black mt-2 bg-red-50 p-2 rounded-lg border border-red-100 uppercase italic">
                            {{ $errorBag->first('password') }}
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full border-2 border-slate-100 bg-slate-50 rounded-2xl p-3.5 focus:border-blue-500 outline-none transition-all font-bold">
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" @click="modalOpen = false" class="flex-1 px-4 py-3.5 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition uppercase text-xs">CANCELAR</button>
                    <button type="submit" class="flex-1 px-4 py-3.5 bg-blue-700 text-white rounded-2xl font-bold hover:bg-blue-800 shadow-lg uppercase text-xs tracking-widest tracking-tighter">ACTUALIZAR</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EL SCRIPT DEBE ESTAR DENTRO DEL DIV PRINCIPAL --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status') == 'password-updated')
                Swal.fire({
                    icon: 'success', 
                    title: '¡Hecho!', 
                    text: 'Contraseña actualizada correctamente.', 
                    confirmButtonColor: '#1d4ed8',
                    customClass: { popup: 'rounded-[2rem]' }
                });
            @endif
        });
    </script>
</div> {{-- FIN DEL ÚNICO ELEMENTO RAÍZ --}}