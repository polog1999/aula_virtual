<div class="p-4 md:p-8 bg-gray-50 min-h-screen font-sans">
    @section('vista', 'Mi Aula Virtual')

    <div class="max-w-7xl mx-auto">
        <!-- Header (Buscador y Título) -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tighter uppercase leading-none">Mi Aula Virtual</h1>
                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-2 italic">Capacitación e Innovación INSN</p>
            </div>
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-blue-500">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Buscar curso..." 
                    class="w-full pl-12 pr-4 py-3.5 bg-white border-none shadow-md rounded-2xl focus:ring-4 focus:ring-blue-100 transition-all text-sm font-bold text-gray-600 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- SIDEBAR: CURSOS MATRICULADOS -->
            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2">Mis Inscripciones</h3>
                @forelse($this->matriculas as $mat)
                    <div wire:click="selectCurso({{ $mat->id }})" 
                        class="group cursor-pointer bg-white border-2 p-6 rounded-[2.5rem] transition-all duration-500 {{ $selectedMatriculaId == $mat->id ? 'border-blue-600 shadow-2xl shadow-blue-100 scale-[1.02]' : 'border-transparent hover:border-gray-200 shadow-sm' }}">
                        <div class="flex justify-between items-center mb-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-black rounded-lg uppercase tracking-widest">{{ $mat->seccion->nombre }}</span>
                            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-600 transition-colors"></i>
                        </div>
                        <h4 class="text-lg font-black text-gray-800 leading-tight uppercase mb-4">{{ $mat->seccion->curso->nombre }}</h4>
                        <div class="space-y-2 border-t border-gray-50 pt-4">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter"><i class="fa-solid fa-calendar-day mr-2 text-blue-500"></i>{{ $mat->seccion->dia_semana }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter"><i class="fa-solid fa-user-tie mr-2 text-blue-500"></i>{{ $mat->seccion->docentes->user->nombres }}</p>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-10 rounded-[2.5rem] text-center shadow-sm border-2 border-dashed border-gray-200 uppercase font-black text-gray-400 text-xs">No hay cursos</div>
                @endforelse
            </div>

            <!-- CONTENIDO: MÓDULOS Y CALIFICACIONES -->
            <div class="lg:col-span-8">
                @if($this->matricula_seleccionada)
                <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 overflow-hidden animate-in fade-in duration-700">
                    
                    <div class="p-10 bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white relative">
                        <div class="relative z-10">
                            <h2 class="text-4xl font-black uppercase tracking-tighter mb-2">{{ $this->matricula_seleccionada->seccion->curso->nombre }}</h2>
                            <p class="text-blue-200 text-xs font-bold uppercase tracking-[0.2em] italic">Contenido Académico y Calificaciones</p>
                        </div>
                        <i class="fa-solid fa-award absolute -right-6 -bottom-6 text-white/10 text-9xl"></i>
                    </div>

                    <div class="p-8 md:p-12">
                        <div class="space-y-6">
                            @foreach($this->matricula_seleccionada->seccion->curso->modulos as $modulo)
                            <div class="bg-gray-50/50 rounded-[2.5rem] border border-gray-100 overflow-hidden transition-all shadow-sm">
                                <button wire:click="toggleModulo({{ $modulo->id }})" class="w-full flex items-center justify-between p-7 group">
                                    <div class="flex items-center gap-6 text-left">
                                        <div class="w-14 h-14 flex items-center justify-center bg-white text-blue-700 rounded-2xl font-black text-xl shadow-md border border-gray-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                            {{ $modulo->orden }}
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-700 uppercase tracking-tight text-base">{{ $modulo->nombre }}</h4>
                                            <p class="text-[10px] text-blue-500 font-black uppercase tracking-widest">Unidad de Aprendizaje</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-plus text-gray-300 transition-transform duration-500 {{ in_array($modulo->id, $openModules) ? 'rotate-45 text-blue-600' : '' }}"></i>
                                </button>

                                <div class="{{ in_array($modulo->id, $openModules) ? 'block' : 'hidden' }} animate-in slide-in-from-top-4">
                                    <div class="p-6 pt-0 space-y-4">
                                        @foreach($modulo->sesiones as $sesion)
                                        @php
                                            // Buscar si esta sesión tiene nota en la colección de la matrícula
                                            $calificacion = $this->matricula_seleccionada->calificaciones->where('sesion_id', $sesion->id)->first();
                                        @endphp
                                        <div class="bg-white p-6 rounded-[2.2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-center gap-5">
                                                <div class="w-12 h-12 rounded-2xl {{ $sesion->es_evaluacion ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600' }} flex items-center justify-center shadow-inner">
                                                    <i class="fa-solid {{ $sesion->es_evaluacion ? 'fa-file-signature' : 'fa-play' }} text-lg"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-sm font-black text-gray-800 uppercase tracking-tight">{{ $sesion->titulo }}</h5>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $sesion->es_evaluacion ? 'Evaluación' : 'Tema de Clase' }}</span>
                                                        
                                                        {{-- MOSTRAR NOTA RÁPIDA --}}
                                                        @if($sesion->es_evaluacion && $calificacion)
                                                            <span class="px-2 py-0.5 {{ $calificacion->nota >= 10.5 ? 'bg-green-600' : 'bg-red-600' }} text-white text-[9px] font-black rounded-full uppercase italic shadow-sm">
                                                                Nota: {{ number_format($calificacion->nota, 1) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button wire:click="openResourceModal({{ $sesion->id }})" 
                                                class="px-6 py-3 bg-blue-600 hover:bg-[#3a348b] text-white text-[10px] font-black uppercase rounded-2xl transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 active:scale-95">
                                                <i class="fa-solid fa-layer-group"></i> VER DETALLES
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-48 bg-white rounded-[3.5rem] border-2 border-dashed border-gray-100 text-center px-10">
                    <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center text-blue-200 mb-8 animate-pulse">
                        <i class="fa-solid fa-graduation-cap text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Tu Futuro Comienza Aquí</h3>
                    <p class="text-gray-400 max-w-sm mt-4 text-sm font-medium leading-relaxed italic uppercase tracking-tighter">Selecciona un curso para ver tu progreso y descargar material.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL DE RECURSO, DESCRIPCIÓN Y NOTA -->
    @if($isResourceModalOpen && $sesionSeleccionada)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-md transition-all">
        <div class="bg-white w-full max-w-3xl rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
            
            <div class="px-10 py-8 bg-blue-700 text-white flex justify-between items-center relative">
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-[0.4em] text-blue-300">Contenido del Tema</span>
                    <h2 class="text-2xl font-black uppercase tracking-tighter mt-1">{{ $sesionSeleccionada->titulo }}</h2>
                </div>
                <button wire:click="closeResourceModal" class="text-white/50 hover:text-white text-5xl transition-colors relative z-10">&times;</button>
                <i class="fa-solid fa-file-invoice absolute -right-4 -bottom-4 text-white/10 text-8xl"></i>
            </div>
            
            <div class="p-10 space-y-8">
                {{-- MOSTRAR NOTA DESTACADA EN EL MODAL --}}
                @if($sesionSeleccionada->es_evaluacion)
                <div class="flex items-center justify-between p-6 rounded-[2rem] {{ $notaSesion !== null ? ($notaSesion >= 10.5 ? 'bg-green-50 border-2 border-green-100' : 'bg-red-50 border-2 border-red-100') : 'bg-gray-50 border-2 border-gray-100' }}">
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-widest {{ $notaSesion !== null ? ($notaSesion >= 10.5 ? 'text-green-700' : 'text-red-700') : 'text-gray-500' }}">Resultado Obtenido</h4>
                        <p class="text-sm font-bold text-gray-600 uppercase tracking-tighter mt-1">Calificación de la evaluación por el docente</p>
                    </div>
                    <div class="text-center">
                        <span class="text-4xl font-black {{ $notaSesion !== null ? ($notaSesion >= 10.5 ? 'text-green-600' : 'text-red-600') : 'text-gray-300' }}">
                            {{ $notaSesion !== null ? number_format($notaSesion, 1) : '--' }}
                        </span>
                        <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest">Puntos</span>
                    </div>
                </div>
                @endif

                <!-- Descripción -->
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-quote-left text-blue-600"></i> Descripción del Docente
                    </h4>
                    <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 text-sm text-gray-600 leading-relaxed font-medium uppercase tracking-tight">
                        {{ $sesionSeleccionada->descripcion ?? 'El docente no ha ingresado una descripción específica.' }}
                    </div>
                </div>

                <!-- Recursos -->
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-blue-600"></i> Material de Estudio
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($sesionSeleccionada->recursos as $recurso)
                        <a href="{{ $recurso->tipo == 'ARCHIVO' ? asset('storage/' . $recurso->url_path) : $recurso->url_path }}" 
                           target="_blank"
                           class="group flex items-center justify-between p-4 bg-white border-2 border-gray-100 rounded-[1.5rem] hover:border-blue-600 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $recurso->tipo == 'ARCHIVO' ? 'bg-red-50 text-red-500' : 'bg-indigo-50 text-indigo-600' }}">
                                    <i class="fa-solid {{ $recurso->tipo == 'ARCHIVO' ? 'fa-file-pdf' : 'fa-link' }}"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-700 uppercase tracking-tighter leading-none truncate w-32">{{ $recurso->nombre }}</p>
                                    <span class="text-[8px] font-bold text-gray-400 uppercase italic">{{ $recurso->tipo }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full py-6 text-center bg-gray-50 rounded-[2rem] border-2 border-dashed border-gray-200">
                            <p class="text-[9px] text-gray-400 font-black uppercase italic tracking-widest uppercase">No hay material adjunto</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button wire:click="closeResourceModal" class="px-10 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-black uppercase rounded-2xl transition-all tracking-widest">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>