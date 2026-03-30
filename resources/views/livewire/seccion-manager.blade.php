<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Gestión de Horarios y Secciones</h1>
                <p class="text-gray-500 text-sm">Administra los grupos, docentes y calendarios automáticos.</p>
            </div>
            <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> CREAR NUEVA SECCIÓN
            </button>
        </div>

        <!-- Filtros -->
        <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 mb-6 flex gap-4">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, curso o docente..." 
                    class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-100 font-medium text-gray-600">
            </div>
        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase">Curso / Sección</th>
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase">Docente</th>
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase text-center">Vacantes</th>
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase">Periodo</th>
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase">Estado</th>
                        <th class="p-5 text-[10px] font-black text-gray-400 uppercase text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($secciones_list as $seccion)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-5">
                            <p class="font-bold text-gray-800">{{ $seccion->curso->nombre }}</p>
                            <span class="text-xs font-bold text-indigo-600 uppercase">{{ $seccion->nombre }}</span>
                        </td>
                        <td class="p-5 text-sm font-medium text-gray-600">
                            {{ $seccion->docentes->user->nombres }} {{ $seccion->docentes->user->apellido_paterno }}
                        </td>
                        <td class="p-5 text-center">
                            <div class="inline-flex flex-col">
                                <span class="text-sm font-black text-gray-800">{{ $seccion->matriculas_activas }} / {{ $seccion->vacantes }}</span>
                                <div class="w-16 h-1.5 bg-gray-100 rounded-full mt-1 overflow-hidden">
                                    <div class="bg-indigo-500 h-full" style="width: {{ ($seccion->matriculas_activas / $seccion->vacantes) * 100 }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="text-xs font-bold px-3 py-1 bg-gray-100 rounded-full text-gray-500">
                                {{ $seccion->periodo->anio }}-{{ $seccion->periodo->ciclo }}
                            </span>
                        </td>
                        <td class="p-5">
                            @if($seccion->activo)
                            <span class="text-[10px] font-black uppercase px-3 py-1 bg-green-100 text-green-600 rounded-lg italic">Activo</span>
                            @else
                            <span class="text-[10px] font-black uppercase px-3 py-1 bg-red-100 text-red-600 rounded-lg italic">Inactivo</span>
                            @endif
                        </td>
                        <td class="p-5 text-right space-x-2">
                            <button wire:click="openModal({{ $seccion->id }})" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="confirmarAccion('deleteSeccion', {{ $seccion->id }}, '¿Eliminar esta sección?')" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 bg-gray-50/30">
                {{ $secciones_list->links() }}
            </div>
        </div>
    </div>

    <!-- MODAL -->
    @if($isOpen)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-[2.5rem] shadow-2xl animate-in zoom-in duration-200">
            <div class="p-8 pb-0 flex justify-between items-center">
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">{{ $seccion_id ? 'Editar Sección' : 'Nueva Sección' }}</h2>
                <button wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-gray-800 text-3xl">&times;</button>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Columna 1 -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Periodo Académico</label>
                            <select wire:model.live="periodo_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                                <option value="">Seleccionar...</option>
                                @foreach($periodos as $p) <option value="{{ $p->id }}">{{ $p->anio }}-{{ $p->ciclo }}</option> @endforeach
                            </select>
                            @error('periodo_id') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Curso</label>
                            <select wire:model="curso_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                                <option value="">Seleccionar...</option>
                                @foreach($cursos as $c) <option value="{{ $c->id }}">{{ $c->nombre }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Nombre de Sección</label>
                            <input type="text" wire:model="nombre" placeholder="Ej: Grupo A" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        </div>
                    </div>

                    <!-- Columna 2 -->
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Docente Asignado</label>
                            <select wire:model="docente_id" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                                <option value="">Seleccionar...</option>
                                @foreach($docentes as $d) <option value="{{ $d->user_id }}">{{ $d->user->nombres }} {{ $d->user->apellido_paterno }}</option> @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Vacantes Totales</label>
                            <input type="number" wire:model="vacantes" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 ml-1">Fecha Inicio Clases</label>
                            <input type="date" wire:model="fecha_inicio" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-4 focus:ring-indigo-100 font-bold">
                        </div>
                    </div>

                    <!-- Columna 3: Horarios -->
                    <div class="bg-gray-50 p-6 rounded-[2rem] space-y-4">
                        <label class="text-[10px] font-black uppercase text-indigo-400 text-center block tracking-widest">Horarios Semanales</label>
                        
                        @foreach($horarios_form as $index => $horario)
                        <div class="bg-white p-4 rounded-2xl shadow-sm space-y-2 relative">
                            <select wire:model="horarios_form.{{ $index }}.dia_semana" class="w-full text-xs border-none bg-gray-50 rounded-lg font-bold">
                                <option value="">Día...</option>
                                <option value="LUNES">Lunes</option>
                                <option value="MARTES">Martes</option>
                                <option value="MIÉRCOLES">Miércoles</option>
                                <option value="JUEVES">Jueves</option>
                                <option value="VIERNES">Viernes</option>
                                <option value="SÁBADO">Sábado</option>
                                <option value="DOMINGO">Domingo</option>
                            </select>
                            <div class="flex gap-2">
                                <input type="time" wire:model="horarios_form.{{ $index }}.hora_inicio" class="w-1/2 text-[10px] border-none bg-gray-50 rounded-lg">
                                <input type="time" wire:model="horarios_form.{{ $index }}.hora_fin" class="w-1/2 text-[10px] border-none bg-gray-50 rounded-lg">
                            </div>
                            @if(count($horarios_form) > 1)
                            <button type="button" wire:click="removeHorario({{ $index }})" class="absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 rounded-full text-[10px]">&times;</button>
                            @endif
                        </div>
                        @endforeach

                        <button type="button" wire:click="addHorario" class="w-full py-2 border-2 border-dashed border-indigo-200 text-indigo-400 rounded-xl text-xs font-black hover:bg-indigo-50 transition-colors">+ AGREGAR DÍA</button>
                    </div>
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <button type="button" wire:click="$set('isOpen', false)" class="flex-1 py-4 font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors text-sm">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all text-sm">
                        {{ $seccion_id ? 'Actualizar y Regenerar Clases' : 'Guardar y Generar Calendario' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>