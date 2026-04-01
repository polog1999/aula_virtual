<div class="p-4 md:p-8 bg-gray-50 min-h-screen">
    @section('vista', 'Mis Cursos')
    
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-[#3a348b] uppercase tracking-tighter">Panel de Gestión Docente</h1>
                <p class="text-gray-500 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#00aba4] rounded-full animate-pulse"></span>
                    Administración de contenidos y recursos académicos
                </p>
            </div>
            @if($this->secciones->count() > 0)
            <div class="bg-white border-2 border-[#3a348b]/10 px-6 py-3 rounded-2xl shadow-sm">
                <span class="text-[10px] font-black text-gray-400 uppercase block leading-none mb-1">Periodo Actual</span>
                <span class="text-[#3a348b] font-black text-sm uppercase">{{ $this->secciones->first()->periodo->anio }}-{{ $this->secciones->first()->periodo->ciclo }}</span>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- LISTA DE CURSOS (IZQUIERDA) --}}
            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Cursos Asignados</h3>
                @forelse ($this->secciones as $seccion)
                    <div wire:click="selectSeccion({{ $seccion->id }})" 
                         class="cursor-pointer group bg-white rounded-[2rem] p-6 border-2 transition-all duration-300 {{ $seccionSeleccionadaId == $seccion->id ? 'border-[#3a348b] shadow-xl shadow-indigo-100 scale-[1.02]' : 'border-transparent hover:border-gray-200 shadow-sm' }}">
                        
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-black px-3 py-1 rounded-lg uppercase">
                                {{ $seccion->nombre }}
                            </span>
                            <span class="text-[#00aba4] font-black text-xs">{{ $seccion->matriculas_count }} Inscritos</span>
                        </div>

                        <h4 class="font-black text-[#3a348b] uppercase leading-tight group-hover:text-[#9d2581] transition-colors mb-4">
                            {{ $seccion->curso->nombre }}
                        </h4>

                        <div class="flex items-center gap-2 text-[11px] text-gray-400 font-bold uppercase mb-6">
                            <i class="fa-solid fa-calendar-week text-[#00aba4]"></i> {{ $seccion->dia_semana }}
                        </div>
                        
                        <button wire:click.stop="openAlumnosModal({{ $seccion->id }})" class="w-full py-3 bg-[#3a348b] text-white rounded-xl text-[10px] font-black uppercase hover:bg-black transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-users"></i> Ver Lista de Alumnos
                        </button>
                    </div>
                @empty
                    <div class="bg-white rounded-[2rem] p-10 text-center border-2 border-dashed border-gray-200">
                        <i class="fa-solid fa-folder-open text-3xl text-gray-300 mb-2"></i>
                        <p class="text-gray-400 font-bold uppercase text-[10px]">No tienes cursos asignados</p>
                    </div>
                @endforelse
            </div>

            {{-- PANEL DE SESIONES (DERECHA) --}}
            <div class="lg:col-span-8">
                @if($this->seccion_activa)
                    <div class="bg-white rounded-[3rem] shadow-xl border border-gray-100 overflow-hidden animate-in fade-in zoom-in duration-300">
                        {{-- Banner --}}
                        <div class="p-8 bg-gradient-to-r from-[#3a348b] to-[#4c44b3] text-white relative">
                            <div class="relative z-10">
                                <h2 class="text-2xl font-black uppercase tracking-tighter">{{ $this->seccion_activa->curso->nombre }}</h2>
                                <p class="text-xs text-indigo-200 font-bold uppercase mt-1 tracking-widest">Planificador y Recursos de Clase</p>
                            </div>
                            <i class="fa-solid fa-book-bookmark absolute -right-4 -bottom-4 text-white/10 text-8xl"></i>
                        </div>

                        <div class="p-8 space-y-8">
                            @foreach ($this->seccion_activa->curso->modulos as $modulo)
                                <div class="relative pl-8 border-l-2 border-gray-100 space-y-4">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-[#00aba4] rounded-full border-4 border-white shadow-sm"></div>
                                    <h5 class="text-[#3a348b] font-black uppercase text-sm tracking-widest">{{ $modulo->nombre }}</h5>
                                    
                                    <div class="grid grid-cols-1 gap-3">
                                        @forelse ($modulo->sesiones as $sesion)
                                            <div class="bg-gray-50 rounded-[1.5rem] p-5 flex justify-between items-center border border-transparent hover:border-[#00aba4]/30 hover:bg-white transition-all group">
                                                <div class="flex items-center gap-5">
                                                    <div class="w-12 h-12 rounded-2xl {{ $sesion->es_evaluacion ? 'bg-[#ffcd00]/20 text-[#ffcd00]' : 'bg-[#00aba4]/10 text-[#00aba4]' }} flex items-center justify-center shadow-inner">
                                                        <i class="fa-solid {{ $sesion->es_evaluacion ? 'fa-star' : 'fa-play' }} text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-black text-gray-700 uppercase leading-tight">{{ $sesion->titulo }}</p>
                                                        <div class="flex gap-2 mt-1">
                                                            <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded-full {{ $sesion->activo ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                                                                {{ $sesion->activo ? 'Publicado' : 'Borrador' }}
                                                            </span>
                                                            <span class="text-[8px] font-black uppercase text-gray-400">{{ $sesion->recursos->count() }} Archivos/Links</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button wire:click="editSesion({{ $sesion->id }})" class="bg-white p-3 rounded-2xl text-[#3a348b] shadow-sm border border-gray-100 hover:bg-[#3a348b] hover:text-white transition-all active:scale-90">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-[10px] text-gray-400 font-bold uppercase italic ml-4">No hay sesiones en esta unidad.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-40 bg-white rounded-[3rem] border-2 border-dashed border-gray-100 text-center px-10">
                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center text-[#3a348b]/20 mb-6">
                            <i class="fa-solid fa-layer-group text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Gestión de Aula</h3>
                        <p class="text-gray-400 max-w-xs mt-2 text-xs font-medium uppercase leading-relaxed italic">Selecciona uno de tus cursos asignados para comenzar a subir material didáctico.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL: ALUMNOS --}}
    @if($isAlumnosModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-all">
        <div class="bg-white w-full max-w-4xl rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
            <div class="px-8 py-6 bg-[#3a348b] text-white flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold uppercase tracking-tight">Estudiantes Matriculados</h2>
                    <p class="text-[10px] text-indigo-300 uppercase font-black tracking-widest">{{ $nombreSeccionModal }}</p>
                </div>
                <button wire:click="$set('isAlumnosModalOpen', false)" class="text-white/70 hover:text-white text-4xl">&times;</button>
            </div>
            
            <div class="p-8 max-h-[60vh] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase font-black bg-gray-50/50">
                        <tr>
                            <th class="px-4 py-4">Documento</th>
                            <th class="px-4 py-4">Nombre Completo</th>
                            <th class="px-4 py-4 text-center">Edad</th>
                            <th class="px-4 py-4">Padre / Contacto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alumnos as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 font-bold text-gray-600 tracking-tighter">{{ $m->alumnos->user->numero_documento }}</td>
                            <td class="px-4 py-4 font-black text-gray-800 uppercase text-xs">{{ $m->alumnos->user->nombres }} {{ $m->alumnos->user->apellido_paterno }} {{ $m->alumnos->user->apellido_materno }}</td>
                            <td class="px-4 py-4 text-center font-bold text-gray-600">
                                {{ \Carbon\Carbon::parse($m->alumnos->user->fecha_nacimiento)->age }} Años
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-[#9d2581] uppercase leading-none">{{ $m->alumnos->padre->user->nombres ?? 'Independiente' }}</span>
                                    <span class="text-xs font-bold text-gray-400">{{ $m->alumnos->padre->user->telefono ?? $m->alumnos->user->telefono }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL: GESTOR DE SESIÓN Y RECURSOS --}}
    @if($isEditSesionModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm transition-all">
        <div class="bg-white w-full max-w-4xl rounded-[3rem] shadow-2xl overflow-hidden animate-in slide-in-from-bottom-10 duration-500 max-h-[95vh] overflow-y-auto">
            <div class="px-10 py-8 bg-[#3a348b] text-white flex justify-between items-center relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-2xl font-black uppercase tracking-widest italic leading-none mb-1">Editor de Contenido</h2>
                    <p class="text-indigo-300 text-[10px] font-black uppercase tracking-[0.3em]">Sesión: {{ $ses_titulo }}</p>
                </div>
                <button wire:click="$set('isEditSesionModalOpen', false)" class="text-white/70 hover:text-white text-5xl transition-colors relative z-10">&times;</button>
                <i class="fa-solid fa-cloud-arrow-up absolute -right-4 -bottom-4 text-white/10 text-9xl"></i>
            </div>
            
            <div class="p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1 tracking-widest">Título del Tema</label>
                        <input type="text" wire:model="ses_titulo" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-4 font-bold uppercase text-gray-700 focus:ring-4 focus:ring-indigo-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1 tracking-widest">Tipo de Sesión</label>
                        <select wire:model="ses_evaluacion" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-4 font-bold focus:ring-4 focus:ring-indigo-100 transition-all">
                            <option value="0">TEMA DE CLASE (Material)</option>
                            <option value="1">EVALUACIÓN (Examen/Tarea)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1 tracking-widest">Estado de Publicación</label>
                        <select wire:model="ses_activo" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-4 font-bold focus:ring-4 focus:ring-indigo-100 transition-all">
                            <option value="1">PUBLICADO (Visible al alumno)</option>
                            <option value="0">BORRADOR (Solo docente)</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 ml-1 tracking-widest">Descripción o Instrucciones</label>
                        <textarea wire:model="ses_descripcion" rows="2" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-4 font-bold text-gray-600 focus:ring-4 focus:ring-indigo-100 transition-all"></textarea>
                    </div>
                </div>

                {{-- GESTOR DE RECURSOS --}}
                <div class="bg-gray-50 p-8 rounded-[2.5rem] border border-gray-100">
                    <h4 class="text-xs font-black text-[#3a348b] uppercase tracking-widest mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-paperclip"></i> Materiales y Recursos Adjuntos
                    </h4>

                    {{-- Lista Actual --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
                        @forelse($recursos_existentes as $recurso)
                        <div class="flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-gray-100 group">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $recurso->tipo == 'ARCHIVO' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }}">
                                    <i class="fa-solid {{ $recurso->tipo == 'ARCHIVO' ? 'fa-file-pdf' : 'fa-link' }}"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[10px] font-black text-gray-700 truncate uppercase">{{ $recurso->nombre }}</p>
                                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-tighter">{{ $recurso->tipo }}</span>
                                </div>
                            </div>
                            <button wire:click="deleteRecurso({{ $recurso->id }})" class="text-gray-300 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-circle-xmark text-lg"></i>
                            </button>
                        </div>
                        @empty
                        <div class="col-span-2 text-center py-4 text-gray-400 text-[10px] font-black uppercase tracking-widest italic italic">Sin recursos adjuntos todavía</div>
                        @endforelse
                    </div>

                    {{-- Añadir Nuevo Recurso --}}
                    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-[#00aba4]/20">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-1 ml-1">Nombre del Recurso</label>
                                <input type="text" wire:model="nombre_recurso_nuevo" placeholder="Ej: GUÍA DE ESTUDIO" class="w-full bg-gray-50 border-none rounded-xl p-3 text-xs font-bold uppercase">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-1 ml-1">Tipo de Material</label>
                                <select wire:model.live="tipo_recurso_nuevo" class="w-full bg-gray-50 border-none rounded-xl p-3 text-xs font-bold">
                                    <option value="ARCHIVO">DOCUMENTO (PDF / Word / Excel)</option>
                                    <option value="LINK">ENLACE EXTERNO (YouTube / Drive)</option>
                                </select>
                            </div>
                        </div>

                        @if($tipo_recurso_nuevo === 'ARCHIVO')
                        <div class="border-2 border-dashed border-gray-100 p-6 rounded-2xl text-center mb-4 transition-all hover:border-[#00aba4]">
                            <input type="file" wire:model="archivo_nuevo" class="text-[10px] text-gray-400 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:bg-[#00aba4] file:text-white file:font-black file:uppercase file:text-[10px] cursor-pointer">
                            <div wire:loading wire:target="archivo_nuevo" class="text-[9px] text-[#00aba4] font-black mt-3 uppercase animate-pulse">Procesando archivo...</div>
                        </div>
                        @else
                        <div class="mb-4">
                            <input type="text" wire:model="link_nuevo" placeholder="Pega la URL aquí: https://ejemplo.com" class="w-full bg-gray-50 border-none rounded-xl p-3 text-xs font-bold text-blue-600">
                        </div>
                        @endif

                        <button type="button" wire:click="addRecurso" class="w-full py-4 bg-[#00aba4] text-white rounded-[1.2rem] font-black text-[10px] uppercase tracking-widest shadow-lg shadow-teal-100 hover:bg-[#008f89] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus"></i> Añadir Recurso a la Sesión
                        </button>
                    </div>
                </div>

                {{-- Footer Modal --}}
                <div class="flex gap-4">
                    <button type="button" wire:click="$set('isEditSesionModalOpen', false)" class="flex-1 py-4 font-black text-gray-400 uppercase text-xs tracking-widest">Cerrar</button>
                    <button type="button" wire:click="saveSesion" class="flex-1 py-5 bg-[#3a348b] text-white rounded-[2rem] font-black uppercase text-xs tracking-widest shadow-2xl hover:bg-black transition-all active:scale-95">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Finalizar y Guardar Sesión
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Script para SweetAlert --}}
    @script
    <script>
        $wire.on('swal', (event) => {
            const data = event[0];
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                confirmButtonColor: '#3a348b',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold uppercase text-sm'
                }
            });
        });
    </script>
    @endscript
</div>