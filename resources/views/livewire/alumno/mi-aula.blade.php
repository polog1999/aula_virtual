<div class="p-4 md:p-8 bg-gray-50 min-h-screen font-sans">
    @section('vista', 'Mi Aula Virtual')

    <div class="max-w-7xl mx-auto">
        <!-- Header (Igual que antes) -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 text-center md:text-left">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight uppercase">Mi Aula Virtual</h1>
                <p class="text-gray-500 font-medium">Plataforma de aprendizaje e investigación</p>
            </div>
            
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" wire:model.live="search" placeholder="Filtrar mis cursos..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border-none shadow-sm rounded-2xl focus:ring-4 focus:ring-blue-100 transition-all text-sm font-bold text-gray-600 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- SIDEBAR: CURSOS -->
            <div class="lg:col-span-4 space-y-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Mis Cursos Activos</h3>
                @forelse($this->matriculas as $mat)
                    <div wire:click="selectCurso({{ $mat->id }})" 
                        class="group cursor-pointer bg-white border-2 p-5 rounded-[2.5rem] transition-all duration-300 {{ $selectedMatriculaId == $mat->id ? 'border-blue-600 shadow-xl shadow-blue-100 scale-[1.02]' : 'border-transparent hover:border-gray-200 shadow-sm' }}">
                        
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[9px] font-black rounded-lg uppercase tracking-tighter">{{ $mat->seccion->nombre }}</span>
                            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">{{ $mat->seccion->periodo->anio }}-{{ $mat->seccion->periodo->ciclo }}</span>
                        </div>
                        <h4 class="text-lg font-black text-gray-800 leading-tight group-hover:text-blue-700 transition-colors uppercase">{{ $mat->seccion->curso->nombre }}</h4>
                        
                        <div class="mt-4 pt-4 border-t border-gray-50 space-y-2">
                            <div class="flex items-center gap-3 text-xs text-gray-500 font-bold uppercase tracking-tighter">
                                <i class="fa-solid fa-calendar-day text-blue-500 w-4"></i> {{ $mat->seccion->dia_semana }}
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-400 font-bold uppercase tracking-tighter">
                                <i class="fa-solid fa-user-tie text-blue-300 w-4"></i> Prof. {{ $mat->seccion->docentes->user->nombres }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-10 rounded-[2.5rem] text-center border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 font-bold text-[10px] uppercase tracking-widest italic">No se encontraron cursos activos</p>
                    </div>
                @endforelse
            </div>

            <!-- CONTENIDO: UNIDADES Y TEMAS -->
            <div class="lg:col-span-8">
                @if($this->matricula_seleccionada)
                <div class="bg-white rounded-[3rem] shadow-xl border border-gray-100 overflow-hidden animate-in fade-in zoom-in duration-500">
                    
                    <div class="p-10 bg-gradient-to-br from-blue-700 to-blue-900 text-white relative">
                        <div class="relative z-10">
                            <h2 class="text-4xl font-black uppercase tracking-tighter mb-4">{{ $this->matricula_seleccionada->seccion->curso->nombre }}</h2>
                            <div class="flex flex-wrap gap-4">
                                <span class="bg-white/10 px-4 py-2 rounded-2xl backdrop-blur-md border border-white/10 text-xs font-bold uppercase tracking-tighter">
                                    <i class="fa-solid fa-id-badge text-blue-300 mr-2"></i> {{ $this->matricula_seleccionada->seccion->docentes->user->nombres }}
                                </span>
                            </div>
                        </div>
                        <i class="fa-solid fa-graduation-cap absolute -right-10 -bottom-10 text-white/5 text-[12rem]"></i>
                    </div>

                    <div class="p-8 md:p-12">
                        <div class="space-y-6">
                            @forelse($this->matricula_seleccionada->seccion->curso->modulos as $modulo)
                            <div class="bg-gray-50/50 rounded-[2.5rem] border border-gray-100 overflow-hidden transition-all">
                                <button wire:click="toggleModulo({{ $modulo->id }})" class="w-full flex items-center justify-between p-6 group">
                                    <div class="flex items-center gap-5 text-left">
                                        <div class="w-12 h-12 flex items-center justify-center bg-white text-blue-700 rounded-2xl font-black text-lg shadow-sm border border-gray-100 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                            {{ $modulo->orden }}
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-700 uppercase tracking-tight text-base">{{ $modulo->nombre }}</h4>
                                            <p class="text-[10px] text-blue-500 font-black uppercase tracking-widest">{{ $modulo->sesiones->count() }} Temas publicados</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-500 {{ in_array($modulo->id, $openModules) ? 'rotate-180 text-blue-600' : '' }}"></i>
                                </button>

                                <div class="{{ in_array($modulo->id, $openModules) ? 'block' : 'hidden' }} animate-in slide-in-from-top-2">
                                    <div class="p-6 pt-0 space-y-3">
                                        @foreach($modulo->sesiones as $sesion)
                                        <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-2xl {{ $sesion->es_evaluacion ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }} flex items-center justify-center">
                                                    <i class="fa-solid {{ $sesion->es_evaluacion ? 'fa-clipboard-check' : 'fa-play' }}"></i>
                                                </div>
                                                <div>
                                                    <h5 class="text-sm font-black text-gray-800 uppercase tracking-tight">{{ $sesion->titulo }}</h5>
                                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ $sesion->recursos->count() }} Recursos adjuntos</p>
                                                </div>
                                            </div>
                                            
                                            {{-- BOTÓN PARA VER RECURSO --}}
                                            <button wire:click="openResourceModal({{ $sesion->id }})" 
                                                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black uppercase rounded-xl transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 active:scale-95">
                                                <i class="fa-solid fa-eye"></i> VER MATERIAL
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center py-20 text-gray-400 font-bold uppercase text-xs tracking-widest italic">El docente aún no ha publicado contenido</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-48 bg-white rounded-[3.5rem] border-2 border-dashed border-gray-100 text-center px-10">
                    <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center text-blue-200 mb-8 animate-pulse">
                        <i class="fa-solid fa-laptop-medical text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Bienvenido a tu Aula</h3>
                    <p class="text-gray-400 max-w-sm mt-4 text-sm font-medium">Selecciona un curso de la izquierda para ver el material de estudio y tus evaluaciones.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL DE RECURSO Y DETALLE DE SESIÓN -->
    @if($isResourceModalOpen && $sesionSeleccionada)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-md transition-all">
        <div class="bg-white w-full max-w-3xl rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
            
            <!-- Header Modal -->
            <div class="px-10 py-8 bg-blue-700 text-white flex justify-between items-center relative overflow-hidden">
                <div class="relative z-10">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-blue-200">Detalle del Tema</span>
                    <h2 class="text-2xl font-black uppercase tracking-tighter mt-1">{{ $sesionSeleccionada->titulo }}</h2>
                </div>
                <button wire:click="closeResourceModal" class="text-white/70 hover:text-white text-4xl transition-colors relative z-10">&times;</button>
                <i class="fa-solid fa-folder-open absolute -right-4 -bottom-4 text-white/10 text-8xl"></i>
            </div>
            
            <div class="p-10 space-y-8">
                <!-- Descripción -->
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-blue-600"></i> Descripción y Actividades
                    </h4>
                    <div class="bg-gray-50 p-6 rounded-[2rem] border border-gray-100 text-sm text-gray-600 leading-relaxed font-medium uppercase tracking-tight">
                        {{ $sesionSeleccionada->descripcion ?? 'No hay descripción disponible para este tema.' }}
                    </div>
                </div>

                <!-- Recursos -->
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-download text-blue-600"></i> Material y Enlaces de Interés
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($sesionSeleccionada->recursos as $recurso)
                        <a href="{{ $recurso->tipo == 'ARCHIVO' ? asset('storage/' . $recurso->url_path) : $recurso->url_path }}" 
                           target="_blank"
                           class="group flex items-center justify-between p-4 bg-white border-2 border-gray-100 rounded-2xl hover:border-blue-600 hover:bg-blue-50 transition-all duration-300 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $recurso->tipo == 'ARCHIVO' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                    <i class="fa-solid {{ $recurso->tipo == 'ARCHIVO' ? 'fa-file-pdf' : 'fa-link' }} text-base"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-700 uppercase tracking-tighter leading-none mb-1">{{ $recurso->nombre }}</p>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase italic">{{ $recurso->tipo }}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-external-link text-gray-300 group-hover:text-blue-600 transition-colors text-sm"></i>
                        </a>
                        @empty
                        <div class="col-span-full py-6 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-[10px] text-gray-400 font-bold uppercase italic tracking-widest">No hay archivos ni enlaces publicados aún</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button wire:click="closeResourceModal" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-black uppercase rounded-2xl transition-all tracking-widest">
                        Cerrar Vista
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>