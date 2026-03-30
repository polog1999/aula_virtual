<div class="min-h-screen bg-[#f0f4f8] py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden border-t-[10px] border-[#004a99]">
        
        {{-- Header --}}
        <div class="p-8 text-center bg-gray-50 border-b border-gray-100">
            <span class="text-[#004a99] font-black text-xl tracking-tighter uppercase block mb-2">INSN - BREÑA</span>
            <h1 class="text-2xl font-black text-[#003366] uppercase leading-tight mb-3">Plan de Capacitación 2026</h1>
            <p class="text-gray-500 text-sm font-medium max-w-xl mx-auto italic">
                Diagnóstico y manejo de patologías prevalentes de la infancia y detección temprana.
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-8 md:p-12 space-y-8">
            
            {{-- Sección: Datos Personales --}}
            <div>
                <h2 class="flex items-center gap-3 text-[#004a99] font-black uppercase tracking-widest text-xs mb-6 bg-[#e7f1ff] p-3 rounded-xl">
                    <i class="fa-solid fa-user-doctor"></i> Datos del Participante
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Nombres Completos</label>
                        <input type="text" wire:model="nombres" placeholder="Ej. Juan Ignacio" 
                            class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white transition-all outline-none font-bold text-gray-700">
                        @error('nombres') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Apellidos Completos</label>
                        <input type="text" wire:model="apellidos" placeholder="Ej. Pérez García" 
                            class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white transition-all outline-none font-bold text-gray-700">
                        @error('apellidos') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">DNI (8 Dígitos)</label>
                        <input type="text" wire:model="dni" maxlength="8" placeholder="00000000"
                            class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white transition-all outline-none font-bold text-gray-700">
                        @error('dni') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">N° Colegiatura</label>
                        <input type="text" wire:model="colegiatura" placeholder="Ej. 123456" 
                            class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white transition-all outline-none font-bold text-gray-700">
                        @error('colegiatura') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Correo Electrónico</label>
                        <input type="email" wire:model="email" placeholder="ejemplo@correo.com" 
                            class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white transition-all outline-none font-bold text-gray-700">
                        @error('email') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Profesión</label>
                        <select wire:model="profesion" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white outline-none font-bold text-gray-700">
                            <option value="">Seleccione...</option>
                            <option value="Medico">Médico</option>
                            <option value="Enfermera">Enfermera</option>
                            <option value="Tecnico">Técnico en Enfermería</option>
                            <option value="Psicologo">Psicólogo</option>
                            <option value="Otros">Otros Profesionales</option>
                        </select>
                        @error('profesion') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Nivel Establecimiento</label>
                        <select wire:model="nivel" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] focus:bg-white outline-none font-bold text-gray-700">
                            <option value="">Seleccione...</option>
                            <option value="I-1">I-1</option><option value="I-2">I-2</option>
                            <option value="I-3">I-3</option><option value="I-4">I-4</option>
                            <option value="II-1">II-1</option><option value="II-2">II-2</option>
                        </select>
                        @error('nivel') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Sección: SUSALUD --}}
            <div>
                <h2 class="flex items-center gap-3 text-[#00aba4] font-black uppercase tracking-widest text-xs mb-6 bg-[#f0fdfa] p-3 rounded-xl border border-[#00aba4]/20">
                    <i class="fa-solid fa-hospital"></i> Ubicación y Establecimiento (SUSALUD)
                </h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Región / Departamento</label>
                        <select wire:model.live="region_vivienda" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] outline-none font-bold text-gray-700">
                            <option value="">Seleccione Región...</option>
                            <option value="LIMA">Lima Provincia</option>
                            <option value="CALLAO">Callao</option>
                            <option value="AMAZONAS">Amazonas</option>
                            <option value="ANCASH">Ancash</option>
                            <option value="APURIMAC">Apurímac</option>
                            <option value="AREQUIPA">Arequipa</option>
                            <option value="AYACUCHO">Ayacucho</option>
                            <option value="ICA">Ica</option>
                            <option value="PIURA">Piura</option>
                            {{-- Agrega los demás departamentos aquí --}}
                        </select>
                        @error('region_vivienda') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">DIRIS / DIRESA Perteneciente</label>
                        <select wire:model="diris_diresa" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] outline-none font-bold text-gray-700" {{ empty($diris_options) ? 'disabled' : '' }}>
                            <option value="">Seleccione DIRIS/DIRESA...</option>
                            @foreach($diris_options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('diris_diresa') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#003366] uppercase mb-2 ml-1">Nombre del Establecimiento</label>
                        <select wire:model="establecimiento" class="w-full p-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-[#007bff] outline-none font-bold text-gray-700">
                            <option value="">Seleccione...</option>
                            <option value="Hosp. Almenara">Hospital Nacional Guillermo Almenara Irigoyen</option>
                            <option value="CS San Martin">Centro de Salud San Martín de Porres</option>
                            <option value="Posta VES">Posta Médica Villa El Salvador</option>
                            <option value="CSM Pueblo Libre">Centro de Salud Mental Pueblo Libre</option>
                        </select>
                        <p class="text-[10px] font-bold text-[#00aba4] mt-2 ml-1 italic tracking-tight uppercase">Sincronizado con base de datos de SUSALUD</p>
                        @error('establecimiento') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full py-5 bg-[#004a99] hover:bg-[#003366] text-white rounded-[2rem] font-black text-lg uppercase tracking-widest shadow-xl shadow-blue-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                <span wire:loading.remove>REGISTRAR PARTICIPACIÓN</span>
                <span wire:loading><i class="fa-solid fa-spinner fa-spin"></i> PROCESANDO...</span>
            </button>
        </form>
    </div>

    {{-- Script para SweetAlert2 --}}
    @script
    <script>
        $wire.on('swal', (event) => {
            const data = event[0];
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                confirmButtonColor: '#004a99',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold uppercase text-sm'
                }
            });
        });
    </script>
    @endscript
</div>