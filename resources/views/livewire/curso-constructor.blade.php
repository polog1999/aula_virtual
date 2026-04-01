<div class="p-6 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 text-center md:text-left">
            <div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight uppercase">Constructor de Cursos</h1>
                <p class="text-gray-500 font-medium italic uppercase text-xs">Define el molde estructural de tu aula virtual</p>
            </div>
            <button wire:click="openCourseModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 transition-all font-bold flex items-center justify-center gap-2 text-xs">
                <i class="fa-solid fa-plus"></i> CREAR NUEVO CURSO
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Catálogo Lateral -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                    <div class="p-5 border-b bg-gray-50/50 flex justify-between items-center uppercase">
                        <span class="text-[10px] font-black text-gray-400 tracking-widest">Catálogo de Cursos</span>
                        <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black px-2 py-0.5 rounded-full">{{ count($cursos) }}</span>
                    </div>
                    <div class="divide-y divide-gray-50 max-h-[calc(100vh-250px)] overflow-y-auto">
                        @foreach ($cursos as $curso)
                        <div class="group relative flex items-center transition-all {{ $cursoSeleccionadoId == $curso->id ? 'bg-indigo-50' : 'hover:bg-gray-50' }}">
                            <button wire:click="selectCurso({{ $curso->id }})" class="flex-1 text-left p-4 pr-12 focus:outline-none">
                                <p class="font-bold {{ $cursoSeleccionadoId == $curso->id ? 'text-indigo-700' : 'text-gray-700' }} leading-tight uppercase text-sm">
                                    {{ $curso->nombre }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-black tracking-tighter">
                                    {{ $curso->modulos_count }} Unidades • {{ $curso->categoria->nombre ?? 'Sin cat.' }}
                                </p>
                            </button>
                            <button onclick="confirmarAccion('deleteCurso', {{ $curso->id }}, '¿Eliminar curso?')" class="absolute right-4 p-2 text-gray-300 hover:text-red-500 transition-all">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Estructura del Curso Seleccionado -->
            <div class="lg:col-span-8">
                @if ($this->curso_seleccionado)
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 animate-in fade-in duration-500">
                    <div class="flex flex-col sm:flex-row justify-between gap-6 mb-10 pb-6 border-b border-gray-50">
                        <div class="flex gap-4 items-center">
                            <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-inner">
                                <i class="fa-solid fa-layer-group text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-gray-800 leading-none uppercase tracking-tighter">{{ $this->curso_seleccionado->nombre }}</h2>
                                <span class="inline-block mt-2 px-3 py-0.5 bg-green-100 text-green-700 text-[9px] font-black rounded-full uppercase tracking-widest">
                                    {{ $this->curso_seleccionado->activo ? 'Público' : 'Borrador' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="openCourseModal({{ $this->curso_seleccionado->id }})" class="bg-gray-100 hover:bg-gray-200 text-gray-500 px-4 py-2 rounded-xl font-black text-[10px] uppercase transition-colors">
                                <i class="fa-solid fa-gear mr-1"></i> AJUSTES
                            </button>
                            <button wire:click="openModuleModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-black text-[10px] uppercase shadow-lg shadow-indigo-100 transition-all">
                                + AÑADIR UNIDAD
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @forelse ($this->curso_seleccionado->modulos as $modulo)
                        <div class="border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                            <div class="bg-gray-50/80 p-4 flex justify-between items-center border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 flex items-center justify-center bg-white rounded-lg text-indigo-600 font-black text-[10px] border border-gray-200 shadow-sm">{{ $modulo->orden }}</span>
                                    <h3 class="font-black text-gray-700 uppercase text-xs tracking-widest">{{ $modulo->nombre }}</h3>
                                </div>
                                <div class="flex gap-1">
                                    <button wire:click="openSessionModal({{ $modulo->id }})" class="text-[9px] font-black bg-white border border-gray-200 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-600 hover:text-white transition-all uppercase">
                                        + SESIÓN
                                    </button>
                                    <button wire:click="openModuleModal({{ $modulo->id }})" class="text-gray-400 hover:text-indigo-600 p-2"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                    <button onclick="confirmarAccion('deleteModulo', {{ $modulo->id }}, '¿Eliminar unidad?')" class="text-gray-300 hover:text-red-500 p-2"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                </div>
                            </div>

                            <div class="p-3 space-y-2 bg-white">
                                @forelse ($modulo->sesiones as $sesion)
                                <div class="group flex items-center justify-between p-4 rounded-2xl hover:bg-indigo-50/50 transition-colors border border-transparent hover:border-indigo-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px]">
                                            <i class="fa-solid fa-file-lines"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-700 uppercase leading-none">{{ $sesion->titulo }}</p>
                                            <p class="text-[9px] text-gray-400 mt-1 uppercase font-black tracking-widest">Estructura base</p>
                                        </div>
                                    </div>
                                    <div class="flex opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="openSessionModal({{ $modulo->id }}, {{ $sesion->id }})" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fa-solid fa-pen text-xs"></i></button>
                                        <button onclick="confirmarAccion('deleteSesion', {{ $sesion->id }}, '¿Eliminar sesión?')" class="p-2 text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash text-xs"></i></button>
                                    </div>
                                </div>
                                @empty
                                <div class="p-4 text-center text-[9px] text-gray-400 font-black uppercase tracking-widest italic">Unidad sin sesiones definidas</div>
                                @endforelse
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">Este curso no tiene unidades estructurales</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-40 bg-white rounded-[3rem] border border-gray-100 text-center px-6">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-200 mb-6">
                        <i class="fa-solid fa-mouse-pointer text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Selecciona un Curso</h3>
                    <p class="text-gray-400 max-w-xs mt-2 text-xs font-medium uppercase italic">Elige un elemento del catálogo lateral para editar su contenido</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL UNIDAD (SIMPLIFICADO Y AUTOMÁTICO) -->
    @if ($isModuleModalOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden animate-in zoom-in duration-200">
            <div class="px-8 py-6 bg-indigo-600 text-white flex justify-between items-center">
                <h2 class="text-lg font-black uppercase tracking-widest italic">{{ $modulo_id ? 'Editar Fecha Unidad' : 'Nueva Unidad Automática' }}</h2>
                <button wire:click="$set('isModuleModalOpen', false)" class="text-indigo-200 hover:text-white text-3xl">&times;</button>
            </div>
            <form wire:submit.prevent="saveModulo" class="p-8 space-y-6">
                
                <div class="text-center bg-indigo-50 p-4 rounded-2xl border border-indigo-100">
                    <p class="text-xs font-black text-indigo-700 uppercase tracking-widest">{{ $mod_nombre }}</p>
                    <p class="text-[10px] text-indigo-400 font-bold uppercase mt-1">El nombre y orden se gestionan automáticamente</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Disponible desde</label>
                    <input type="date" wire:model="mod_disponible" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold text-gray-700">
                    @error('mod_disponible') <span class="text-red-500 text-[10px] font-bold block mt-1 uppercase">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Estado de la Unidad</label>
                    <select wire:model="mod_activo" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        <option value="1">Activa</option>
                        <option value="0">Inactiva</option>
                    </select>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" wire:click="$set('isModuleModalOpen', false)" class="flex-1 py-4 font-black text-gray-400 uppercase text-xs hover:text-gray-600 transition-colors">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-[1.5rem] font-black uppercase text-[10px] tracking-widest shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase">
                        {{ $modulo_id ? 'Actualizar Unidad' : 'Generar Unidad' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL SESIÓN (SIMPLIFICADO) -->
    @if ($isSessionModalOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-slate-200 overflow-hidden animate-in zoom-in duration-200">
            <div class="px-8 py-6 bg-indigo-600 text-white flex justify-between items-center">
                <h2 class="text-lg font-black uppercase tracking-widest italic">{{ $sesion_id ? 'Editar Molde Sesión' : 'Nueva Sesión' }}</h2>
                <button wire:click="$set('isSessionModalOpen', false)" class="text-indigo-200 hover:text-white text-3xl">&times;</button>
            </div>
            <form wire:submit.prevent="saveSesion" class="p-8 space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Título de la Sesión (Tema)</label>
                    <input type="text" wire:model="ses_titulo" placeholder="Ej: INTRODUCCIÓN AL CURSO" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold uppercase text-gray-700">
                    @error('ses_titulo') <span class="text-red-500 text-[10px] font-bold block mt-1 uppercase">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1 tracking-widest">Visibilidad Inicial</label>
                    <select wire:model="ses_activo" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        <option value="1">VISIBLE</option>
                        <option value="0">OCULTO</option>
                    </select>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" wire:click="$set('isSessionModalOpen', false)" class="flex-1 py-4 font-black text-gray-400 uppercase text-xs hover:text-gray-600 transition-colors">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-[1.5rem] font-black uppercase text-[10px] tracking-widest shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase">Guardar Sesión</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- MODAL CURSO -->
   <!-- Solo incluyo el Modal de Curso actualizado para no repetir todo el código -->
@if ($isCourseModalOpen)
<div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in duration-200">
        <div class="p-8 pb-0 flex justify-between items-center">
            <h2 class="text-xl font-black text-gray-800 uppercase italic tracking-tighter">{{ $curso_id ? 'Editar Curso' : 'Nuevo Curso' }}</h2>
            <button wire:click="$set('isCourseModalOpen', false)" class="text-gray-400 hover:text-gray-800 text-3xl">&times;</button>
        </div>
        <form wire:submit.prevent="saveCurso" class="p-8 space-y-4">
            
            <!-- Preview de Imagen -->
            <div class="flex justify-center mb-4">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-3xl overflow-hidden bg-gray-100 border-4 border-white shadow-lg flex items-center justify-center">
                        @if ($imagen)
                            <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($imagen_actual)
                            <img src="{{ asset('storage/' . $imagen_actual) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                        @endif
                        
                        <!-- Spinner de carga -->
                        <div wire:loading wire:target="imagen" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <i class="fa-solid fa-spinner fa-spin text-indigo-600"></i>
                        </div>
                    </div>
                    <label class="absolute -bottom-2 -right-2 bg-indigo-600 text-white p-2 rounded-xl shadow-lg cursor-pointer hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-camera"></i>
                        <input type="file" wire:model="imagen" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1 ml-1">Nombre del Curso</label>
                <input type="text" wire:model="nombre" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold uppercase text-gray-700">
                @error('nombre') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1 ml-1">Categoría</label>
                    <select wire:model="categoria_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        <option value="">Seleccionar...</option>
                        @foreach ($categorias as $cat) <option value="{{ $cat->id }}">{{ $cat->nombre }}</option> @endforeach
                    </select>
                    @error('categoria_id') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-1 ml-1">Estado</label>
                    <select wire:model="activo" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1 ml-1">Descripción</label>
                <textarea wire:model="descripcion" rows="3" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold text-gray-600"></textarea>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                <span wire:loading.remove wire:target="saveCurso">Guardar Curso</span>
                <span wire:loading wire:target="saveCurso">Procesando...</span>
            </button>
        </form>
    </div>
</div>
@endif
</div>