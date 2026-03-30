<div class="p-4 md:p-8">
    @section('vista', 'Mis Cursos')
    
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Panel del Docente</h1>
                <p class="text-gray-500 font-bold text-xs uppercase tracking-widest">Gestión de contenidos y alumnos asignados</p>
            </div>
            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-2xl font-black text-xs uppercase">
                Periodo: {{ $secciones->first()->periodo->anio ?? '' }}-{{ $secciones->first()->periodo->ciclo ?? '' }}
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- LISTA DE CURSOS ASIGNADOS (IZQUIERDA) -->
            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest ml-2">Cursos Asignados</h3>
                @forelse ($secciones as $seccion)
                    <div wire:click="selectSeccion({{ $seccion->id }})" 
                         class="cursor-pointer group bg-white rounded-3xl p-5 border-2 transition-all {{ $seccionSeleccionadaId == $seccion->id ? 'border-indigo-600 shadow-xl shadow-indigo-100' : 'border-transparent hover:border-gray-200 shadow-sm' }}">
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter">
                                {{ $seccion->nombre }}
                            </span>
                            <span class="text-indigo-600 font-black text-xs">{{ $seccion->matriculas_count }} Alumnos</span>
                        </div>
                        <h4 class="font-black text-gray-800 uppercase leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $seccion->curso->nombre }}
                        </h4>
                        <p class="text-[11px] text-gray-400 font-bold mt-2 uppercase italic">
                            <i class="fa-solid fa-calendar-days mr-1"></i> {{ $seccion->dia_semana }}
                        </p>
                        
                        <div class="mt-4 flex gap-2">
                            <button wire:click.stop="openAlumnosModal({{ $seccion->id }})" class="flex-1 py-2 bg-gray-800 text-white rounded-xl text-[10px] font-black uppercase hover:bg-black transition-colors">
                                <i class="fa-solid fa-users mr-1"></i> Alumnos
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-10 text-center border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 font-bold uppercase text-xs">No tienes cursos asignados este periodo</p>
                    </div>
                @endforelse
            </div>

            <!-- GESTIÓN DE SESIONES / PLANIFICADOR (DERECHA) -->
            <div class="lg:col-span-8">
                @if($this->seccion_activa)
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-8 animate-in fade-in zoom-in duration-300">
                        <div class="flex items-center gap-4 mb-8 border-b border-gray-100 pb-6">
                            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">{{ $this->seccion_activa->curso->nombre }}</h2>
                                <p class="text-xs text-gray-400 font-bold uppercase">Planificador de Clases e Información Académica</p>
                            </div>
                        </div>

                        <div class="space-y-8">
                            @foreach ($this->seccion_activa->curso->modulos as $modulo)
                                <div class="relative pl-8 border-l-2 border-indigo-100 space-y-4">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-indigo-600 rounded-full border-4 border-white"></div>
                                    <h5 class="text-indigo-600 font-black uppercase text-sm tracking-widest">{{ $modulo->nombre }}</h5>
                                    
                                    <div class="grid grid-cols-1 gap-3">
                                        @forelse ($modulo->sesiones as $sesion)
                                            <div class="bg-gray-50 rounded-2xl p-4 flex justify-between items-center border border-transparent hover:border-indigo-200 transition-all group">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl {{ $sesion->es_evaluacion ? 'bg-amber-100 text-amber-600' : 'bg-white text-indigo-600' }} flex items-center justify-center shadow-sm">
                                                        <i class="fa-solid {{ $sesion->es_evaluacion ? 'fa-star' : 'fa-play' }} text-xs"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-black text-gray-700 uppercase">{{ $sesion->titulo }}</p>
                                                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded {{ $sesion->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                            {{ $sesion->activo ? 'Publicado' : 'Borrador' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <button wire:click="editSesion({{ $sesion->id }})" class="bg-white p-2 rounded-xl text-indigo-600 shadow-sm border border-gray-100 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-[10px] text-gray-400 italic">No hay temas definidos para esta unidad.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-40 bg-white rounded-[3rem] border-2 border-dashed border-gray-100 text-center px-6">
                        <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-200 mb-6">
                            <i class="fa-solid fa-layer-group text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Gestión de Contenido</h3>
                        <p class="text-gray-400 max-w-xs mt-2 text-xs font-medium uppercase italic">Selecciona un curso de la izquierda para comenzar a subir material y gestionar tus clases.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL: LISTADO DE ALUMNOS (DISEÑO TAILWIND) -->
    @if($isAlumnosModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl border border-gray-200 overflow-hidden animate-in zoom-in duration-200">
            <div class="px-8 py-6 bg-gray-800 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold uppercase tracking-tight">Lista de Estudiantes</h2>
                    <p class="text-[10px] text-gray-400 uppercase font-black">Sección: {{ $nombreSeccionModal }}</p>
                </div>
                <button wire:click="$set('isAlumnosModalOpen', false)" class="text-white/70 hover:text-white text-3xl">&times;</button>
            </div>
            
            <div class="p-8 max-h-[60vh] overflow-y-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase font-black bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">DNI</th>
                            <th class="px-4 py-3">Alumno</th>
                            <th class="px-4 py-3 text-center">Edad</th>
                            <th class="px-4 py-3">Contacto Apoderado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($alumnos as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-bold text-gray-600">{{ $m->alumnos->user->numero_documento }}</td>
                            <td class="px-4 py-3 font-black text-gray-800 uppercase text-xs">{{ $m->alumnos->user->nombres }} {{ $m->alumnos->user->apellido_paterno }}</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-600">
                                {{ \Carbon\Carbon::parse($m->alumnos->user->fecha_nacimiento)->age }} años
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-indigo-600 uppercase">{{ $m->alumnos->padre->user->nombres ?? 'AUTÓNOMO' }}</span>
                                    <span class="text-xs font-bold text-gray-500">{{ $m->alumnos->padre->user->telefono ?? $m->alumnos->user->telefono }}</span>
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

    <!-- MODAL: EDITAR CONTENIDO DE SESIÓN (EL DOCENTE LLENA EL MOLDE) -->
    @if($isEditSesionModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-indigo-900/40 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden animate-in slide-in-from-bottom-8 duration-300">
            <div class="px-8 py-6 bg-indigo-600 text-white flex justify-between items-center">
                <h2 class="text-lg font-black uppercase tracking-widest italic">Gestionar Tema de Clase</h2>
                <button wire:click="$set('isEditSesionModalOpen', false)" class="text-indigo-200 hover:text-white text-3xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="saveSesion" class="p-8 space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Título del Tema</label>
                    <input type="text" wire:model="ses_titulo" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold uppercase text-gray-700">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Tipo de Actividad</label>
                        <select wire:model="ses_evaluacion" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                            <option value="0">Contenido Académico</option>
                            <option value="1">Evaluación / Examen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Estado de Publicación</label>
                        <select wire:model="ses_activo" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                            <option value="1">Publicado para Alumnos</option>
                            <option value="0">Borrador (Oculto)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Contenido / Link de Recurso (Video, PDF, Drive)</label>
                    <textarea wire:model="ses_descripcion" rows="4" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold text-gray-600" placeholder="Escribe aquí las instrucciones o pega el link del video de la clase..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" wire:click="$set('isEditSesionModalOpen', false)" class="flex-1 py-4 font-black text-gray-400 uppercase text-xs">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-[1.5rem] font-black uppercase text-xs shadow-xl hover:bg-indigo-700 active:scale-95 transition-all">Actualizar Contenido</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>