<div class="p-4 md:p-6 bg-gray-50 min-h-screen font-sans">
    @section('vista', 'Mis Cursos')

    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-2xl font-black text-[#3a348b] uppercase tracking-tighter italic">Panel Docente</h1>
                <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest">Instituto Nacional de Salud del Niño</p>
            </div>
            @if($this->secciones->count() > 0)
            <div class="bg-white border border-gray-200 px-4 py-2 rounded-lg shadow-sm">
                <span class="text-[#3a348b] font-black text-xs uppercase">{{ $this->secciones->first()->periodo->anio }} - {{ $this->secciones->first()->periodo->ciclo }}</span>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Lateral: Cursos --}}
            <div class="lg:col-span-4 space-y-3">
                <h3 class="text-[10px] font-black text-gray-400 uppercase ml-2 tracking-widest">Cursos Asignados</h3>
                @foreach ($this->secciones as $seccion)
                    <div wire:click="selectSeccion({{ $seccion->id }})" 
                         class="cursor-pointer bg-white rounded-lg p-5 border-2 transition-all {{ $seccionSeleccionadaId == $seccion->id ? 'border-[#3a348b] shadow-md' : 'border-transparent shadow-sm hover:border-gray-200' }}">
                        <h4 class="font-black text-[#3a348b] uppercase text-xs mb-3 leading-tight">{{ $seccion->curso->nombre }}</h4>
                        <div class="flex justify-between items-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $seccion->nombre }} | {{ $seccion->matriculas_count }} Alumnos</span>
                            <button wire:click.stop="openAlumnosModal({{ $seccion->id }})" class="bg-[#00aba4] text-white px-2 py-1 rounded text-[8px] font-black uppercase hover:bg-teal-600 transition-all">Notas / Alumnos</button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Contenido Principal --}}
            <div class="lg:col-span-8">
                @if($this->seccion_activa)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-sm font-black text-[#3a348b] uppercase tracking-tighter">{{ $this->seccion_activa->curso->nombre }}</h2>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $this->seccion_activa->dia_semana }}</span>
                        </div>

                        <div class="p-6 space-y-8">
                            @foreach ($this->seccion_activa->curso->modulos as $modulo)
                                <div class="space-y-3">
                                    <h5 class="text-[#00aba4] font-black uppercase text-[10px] tracking-[0.2em] border-l-4 border-[#00aba4] pl-3">{{ $modulo->nombre }}</h5>
                                    <div class="grid grid-cols-1 gap-2">
                                        @foreach ($modulo->sesiones as $sesion)
                                            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center border border-gray-100 hover:bg-gray-100/50 transition-all">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-lg {{ $sesion->es_evaluacion ? 'bg-[#ffcd00]/20 text-[#ffcd00]' : 'bg-[#3a348b]/10 text-[#3a348b]' }} flex items-center justify-center">
                                                        <i class="fa-solid {{ $sesion->es_evaluacion ? 'fa-file-signature' : 'fa-play' }}"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-black text-gray-700 uppercase leading-tight">{{ $sesion->titulo }}</p>
                                                        <span class="text-[8px] font-bold uppercase {{ $sesion->activo ? 'text-green-600' : 'text-gray-400' }}">
                                                            {{ $sesion->activo ? '● Publicado' : '○ Borrador' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    @if($sesion->es_evaluacion)
                                                        <button wire:click="openCalificarModal({{ $sesion->id }})" class="bg-[#ffcd00] text-[#3a348b] px-3 py-1.5 rounded-lg text-[9px] font-black uppercase hover:scale-105 transition-transform shadow-sm">
                                                            <i class="fa-solid fa-star"></i> Calificar
                                                        </button>
                                                    @endif
                                                    <button wire:click="editSesion({{ $sesion->id }})" class="bg-white border border-gray-200 p-2 rounded-lg text-gray-400 hover:text-[#3a348b] transition-colors">
                                                        <i class="fa-solid fa-gear"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="h-64 flex flex-col items-center justify-center bg-white rounded-lg border-2 border-dashed border-gray-200 text-gray-300 uppercase text-[10px] font-black tracking-widest italic">
                        <i class="fa-solid fa-folder-open mb-3 text-3xl"></i>
                        Selecciona un curso para gestionar
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL 1: CUADRO DE NOTAS DINÁMICO --}}
    @if($isAlumnosModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-5xl rounded-lg shadow-2xl overflow-hidden animate-in zoom-in duration-200">
            <div class="px-6 py-4 bg-[#3a348b] text-white flex justify-between items-center font-black uppercase italic text-xs tracking-widest">
                <h2>Cuadro General de Calificaciones - {{ $nombreSeccionModal }}</h2>
                <button wire:click="$set('isAlumnosModalOpen', false)" class="text-xl">&times;</button>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-[10px] text-left border-collapse">
                    <thead class="bg-gray-100 uppercase text-gray-500 font-black">
                        <tr>
                            <th class="px-3 py-4 border">Documento</th>
                            <th class="px-3 py-4 border">Estudiante</th>
                            @foreach($modulosDelCurso as $index => $mod)
                                <th class="px-2 py-4 border text-center w-12" title="{{ $mod->nombre }}">U{{ $index + 1 }}</th>
                            @endforeach
                            <th class="px-3 py-4 border text-center bg-indigo-50 text-[#3a348b] w-16">P</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($alumnosMatriculados as $mat)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-3 border font-bold text-gray-500">{{ $mat->alumnos->user->numero_documento }}</td>
                            <td class="px-3 py-3 border font-black text-gray-800 uppercase tracking-tighter">{{ $mat->alumnos->user->nombres }} {{ $mat->alumnos->user->apellido_paterno }}</td>
                            
                            @php $sumaNotas = 0; $unidadesConNota = 0; @endphp

                            @foreach($modulosDelCurso as $mod)
                                @php
                                    $sesionEval = $mod->sesiones->where('es_evaluacion', true)->first();
                                    $notaObj = $sesionEval ? $mat->calificaciones->where('sesion_id', $sesionEval->id)->first() : null;
                                    $notaVal = $notaObj ? $notaObj->nota : null;
                                    
                                    if($notaVal !== null) { $sumaNotas += $notaVal; $unidadesConNota++; }
                                @endphp
                                <td class="px-2 py-3 border text-center font-black {{ $notaVal < 10.5 && $notaVal !== null ? 'text-red-500' : 'text-blue-600' }}">
                                    {{ $notaVal ?? '-' }}
                                </td>
                            @endforeach

                            <td class="px-3 py-3 border text-center font-black bg-indigo-50 text-[#3a348b] text-xs">
                                {{ $modulosDelCurso->count() > 0 ? number_format($sumaNotas / $modulosDelCurso->count(), 1) : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 text-right">
                <button wire:click="$set('isAlumnosModalOpen', false)" class="bg-[#3a348b] text-white px-6 py-2 rounded-lg text-[10px] font-black uppercase">Cerrar</button>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL 2: CALIFICADOR INDIVIDUAL --}}
    @if($isCalificarModalOpen)
    <div class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-xl rounded-lg shadow-2xl overflow-hidden animate-in zoom-in duration-200">
            <div class="px-6 py-4 bg-[#ffcd00] text-[#3a348b] flex justify-between items-center font-black uppercase text-[10px] tracking-widest">
                <h2>Ingreso de Notas: {{ $tituloSesionCalificar }}</h2>
                <button wire:click="$set('isCalificarModalOpen', false)" class="text-lg">&times;</button>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <table class="w-full text-xs text-left">
                    <tbody class="divide-y divide-gray-100">
                        @foreach($this->seccion_activa->matriculas as $m)
                        <tr>
                            <td class="py-3 font-black text-gray-700 uppercase tracking-tighter">{{ $m->alumnos->user->nombres }} {{ $m->alumnos->user->apellido_paterno }}</td>
                            <td class="py-2 text-right">
                                <input type="number" step="0.1" min="0" max="20" wire:model="notas_input.{{ $m->id }}" 
                                    class="w-20 text-center bg-gray-50 border border-gray-200 rounded-lg p-2 font-black text-[#3a348b] focus:border-[#ffcd00] outline-none">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-5 bg-gray-50 border-t flex justify-end gap-3">
                <button wire:click="guardarNotas" class="bg-[#3a348b] text-white px-8 py-3 rounded-lg text-[10px] font-black uppercase shadow-lg">Guardar Notas</button>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL 3: GESTOR SESIÓN Y RECURSOS --}}
    @if($isEditSesionModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-3xl rounded-lg shadow-2xl overflow-hidden animate-in slide-in-from-bottom-5 duration-300 max-h-[95vh] overflow-y-auto">
            <div class="px-6 py-4 bg-[#3a348b] text-white flex justify-between items-center font-black uppercase text-[10px] tracking-widest italic">
                <h2>Configurar Sesión de Clase</h2>
                <button wire:click="$set('isEditSesionModalOpen', false)" class="text-lg">&times;</button>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-[9px] font-black text-gray-400 uppercase block mb-1">Título del Tema</label>
                        <input type="text" wire:model="ses_titulo" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-3 font-bold uppercase text-xs">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase block mb-1">¿Es Evaluación?</label>
                        <select wire:model.live="ses_evaluacion" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-3 font-bold text-xs">
                            <option value="0">NO (Contenido)</option>
                            <option value="1">SÍ (Evaluación)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase block mb-1">Visibilidad</label>
                        <select wire:model="ses_activo" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-3 font-bold text-xs">
                            <option value="1">Publicado</option>
                            <option value="0">Borrador</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-black text-gray-400 uppercase block mb-1">Descripción / Instrucciones</label>
                    <textarea wire:model="ses_descripcion" rows="2" class="w-full bg-gray-50 border border-gray-100 rounded-lg p-3 font-bold text-xs text-gray-600"></textarea>
                </div>

                {{-- RECURSOS --}}
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h4 class="text-[9px] font-black text-[#3a348b] uppercase tracking-widest mb-4">Recursos de la Sesión</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
                        @foreach($recursos_existentes as $re)
                        <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-100">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <i class="fa-solid {{ $re->tipo == 'ARCHIVO' ? 'fa-file text-red-500' : 'fa-link text-blue-500' }} text-xs"></i>
                                <span class="text-[9px] font-black text-gray-600 uppercase truncate">{{ $re->nombre }}</span>
                            </div>
                            <button wire:click="deleteRecurso({{ $re->id }})" class="text-gray-300 hover:text-red-500 transition-colors"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endforeach
                    </div>

                    <div class="bg-white p-4 rounded-lg border border-gray-200 space-y-3">
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" wire:model="nombre_recurso_nuevo" placeholder="Nombre Recurso" class="w-full bg-gray-50 border-none rounded-lg p-2 text-[10px] font-bold uppercase">
                            <select wire:model.live="tipo_recurso_nuevo" class="w-full bg-gray-50 border-none rounded-lg p-2 text-[10px] font-bold">
                                <option value="ARCHIVO">Archivo</option>
                                <option value="LINK">Link</option>
                            </select>
                        </div>
                        @if($tipo_recurso_nuevo == 'ARCHIVO')
                            <input type="file" wire:model="archivo_nuevo" class="text-[9px]">
                        @else
                            <input type="text" wire:model="link_nuevo" placeholder="https://..." class="w-full bg-gray-50 border-none rounded-lg p-2 text-[10px] font-bold">
                        @endif
                        <button type="button" wire:click="addRecurso" class="w-full bg-[#00aba4] text-white py-2 rounded-lg text-[9px] font-black uppercase shadow-sm">Añadir Recurso</button>
                    </div>
                </div>

                <button wire:click="saveSesion" class="w-full bg-[#3a348b] text-white py-4 rounded-lg font-black uppercase text-xs shadow-lg">Guardar Cambios de Sesión</button>
            </div>
        </div>
    </div>
    @endif

    @script
    <script>
        $wire.on('swal', (event) => {
            const data = event[0];
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                confirmButtonColor: '#3a348b',
                customClass: { popup: 'rounded-lg', confirmButton: 'rounded-md uppercase font-black text-[10px]' }
            });
        });
    </script>
    @endscript
</div>