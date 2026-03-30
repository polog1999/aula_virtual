<div class="p-4 md:p-8">
    @section('vista', 'Matrículas')

    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Gestión de Matrículas</h1>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header: Buscador y Exportación --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Buscar por curso, alumno o DNI..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm font-medium">
                </div>
                
                <button wire:click="exportar" 
                        class="w-full md:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2 uppercase text-xs">
                    <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                </button>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th class="px-6 py-4 w-10">#</th>
                            <th class="px-6 py-4">DNI / Alumno</th>
                            <th class="px-6 py-4">Curso y Sección</th>
                            <th class="px-6 py-4 text-center">F. Matrícula</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 w-20 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($matriculas_list as $index => $m)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 text-gray-400 font-bold">
                                    {{ ($matriculas_list->firstItem() + $index) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 uppercase">
                                        {{ $m->alumnos?->user->nombres }} {{ $m->alumnos?->user->apellido_paterno }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 font-bold">
                                        DNI: {{ $m->alumnos?->user->numero_documento }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-indigo-700 uppercase">
                                        {{ $m->seccion?->curso->nombre }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 font-medium uppercase">
                                        Sección: {{ $m->seccion?->nombre }} | Docente: {{ $m->seccion?->docentes->user->nombres }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($m->fecha_matricula)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $color = match($m->estado) {
                                            'ACTIVA' => 'bg-green-100 text-green-700',
                                            'INACTIVA' => 'bg-gray-100 text-gray-600',
                                            'RETIRADO' => 'bg-red-100 text-red-700',
                                            'FINALIZADO' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-yellow-100 text-yellow-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $color }}">
                                        {{ $m->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="openModal({{ $m->id }})" 
                                            class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No se encontraron matrículas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $matriculas_list->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl mx-4 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
            {{-- Header Modal --}}
            <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold uppercase tracking-tight">Editar Estado de Matrícula</h2>
                <button wire:click="$set('isModalOpen', false)" class="text-white/70 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Cambiar a Taller / Sección</label>
                        <select wire:model="seccion_id" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold transition-all uppercase">
                            <option value="">Seleccionar sección...</option>
                            @foreach ($secciones_list_select as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->curso?->nombre }} ({{ $s->nombre }}) - {{ $s->docentes->user->nombres }} {{ $s->docentes->user->apellido_paterno }}
                                </option>
                            @endforeach
                        </select>
                        @error('seccion_id') <span class="text-red-500 text-[10px] font-bold block mt-1 uppercase">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Estado del Alumno</label>
                        <select wire:model="estado" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold transition-all">
                            <option value="">Seleccionar estado...</option>
                            <option value="ACTIVA">ACTIVA</option>
                            <option value="INACTIVA">INACTIVA</option>
                            <option value="RETIRADO">RETIRADO</option>
                            <option value="FINALIZADO">FINALIZADO</option>
                        </select>
                        @error('estado') <span class="text-red-500 text-[10px] font-bold block mt-1 uppercase">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex gap-3 pt-6 border-t border-gray-100">
                    <button type="button" wire:click="$set('isModalOpen', false)" 
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition uppercase text-xs tracking-widest">
                        CANCELAR
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-blue-700 text-white rounded-xl font-bold hover:bg-blue-800 shadow-lg transform active:scale-95 transition-all uppercase text-xs tracking-widest">
                        ACTUALIZAR MATRÍCULA
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>