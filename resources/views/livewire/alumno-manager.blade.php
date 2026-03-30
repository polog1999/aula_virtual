<div class="p-4 md:p-8">
    @section('vista', 'Alumnos')

    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Gestión de Alumnos</h1>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header: Buscador --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Buscar por DNI o nombres..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all text-sm font-medium">
                </div>
                
                <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    {{ $users_list->total() }} Alumnos encontrados
                </div>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th class="px-6 py-4 w-32">N° Documento</th>
                            <th class="px-6 py-4">Alumno</th>
                            <th class="px-6 py-4">Cursos Matriculados</th>
                            <th class="px-6 py-4 w-32 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users_list as $user)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-600">
                                    {{ $user->numero_documento }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 uppercase">
                                        {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}
                                    </div>
                                    <span class="text-[10px] text-indigo-500 font-bold uppercase tracking-tighter">{{ $user->tipo_documento }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->alumno && $user->alumno->matricula->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->alumno->matricula as $m)
                                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-[10px] font-bold border border-green-100 uppercase">
                                                    {{ $m->seccion->curso->nombre }} ({{ $m->seccion->curso->categoria->nombre }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Sin matrículas activas</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button wire:click="openModal({{ $user->id }})" 
                                            class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">No se encontraron alumnos para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $users_list->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl mx-4 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
            {{-- Header Modal --}}
            <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold uppercase tracking-tight">Editar Datos del Alumno</h2>
                <button wire:click="$set('isModalOpen', false)" class="text-white/70 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Nombres</label>
                        <input type="text" wire:model="editNombre" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-semibold uppercase">
                        @error('editNombre') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Ap. Paterno</label>
                        <input type="text" wire:model="editApPaterno" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-semibold uppercase">
                        @error('editApPaterno') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Ap. Materno</label>
                        <input type="text" wire:model="editApMaterno" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-semibold uppercase">
                        @error('editApMaterno') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Tipo de Documento</label>
                        <select wire:model="editTipo" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                            <option value="">Seleccionar...</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>
                        </select>
                        @error('editTipo') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Número de Documento</label>
                        <input type="text" wire:model="editDocumento" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                        @error('editDocumento') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="flex gap-3 pt-6 border-t border-gray-100">
                    <button type="button" wire:click="$set('isModalOpen', false)" 
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition uppercase text-xs tracking-widest">
                        CANCELAR
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-blue-700 text-white rounded-xl font-bold hover:bg-blue-800 shadow-lg transform active:scale-95 transition-all uppercase text-xs tracking-widest">
                        ACTUALIZAR ALUMNO
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>