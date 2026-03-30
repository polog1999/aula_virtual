<div class="p-4 md:p-8">
    @section('vista', 'Categorías')
    
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Gestión de Categorías</h1>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header: Buscador y Botón --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                <div class="relative w-full md:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Buscar categoría..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm transition-all">
                </div>
                
                <button wire:click="openModal()" 
                        class="w-full md:w-auto px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i class="fa fa-plus"></i> NUEVA CATEGORÍA
                </button>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th class="px-6 py-4 w-20"># ID</th>
                            <th class="px-6 py-4">Descripción de la Categoría</th>
                            <th class="px-6 py-4 w-40 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($categorias_list as $categoria)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">#{{ $categoria->id }}</td>
                                <td class="px-6 py-4 text-gray-700 font-semibold uppercase">{{ $categoria->nombre }}</td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <button wire:click="openModal({{ $categoria->id }})" 
                                            class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button onclick="confirmarAccion('deleteCategoria', {{ $categoria->id }}, '¿Eliminar categoría?')" 
                                            class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition" title="Eliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">No se encontraron categorías.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $categorias_list->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
            {{-- Header Modal --}}
            <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold uppercase tracking-tight">{{ $categoriaId ? 'Editar Categoría' : 'Nueva Categoría' }}</h2>
                <button wire:click="$set('isModalOpen', false)" class="text-white/70 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Nombre de la Categoría</label>
                    <input type="text" 
                           wire:model="nombre" 
                           placeholder="Ej: NIÑOS, ADULTOS, etc."
                           class="w-full border @error('nombre') border-red-500 @else border-gray-300 @enderror rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-semibold transition-all">
                    @error('nombre') 
                        <span class="text-red-500 text-[10px] font-bold uppercase mt-1 block ml-1">{{ $message }}</span> 
                    @enderror
                </div>
                
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="button" 
                            wire:click="$set('isModalOpen', false)" 
                            class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition uppercase text-xs tracking-widest">
                        CANCELAR
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-blue-700 text-white rounded-lg font-bold hover:bg-blue-800 shadow-lg transform active:scale-95 transition-all uppercase text-xs tracking-widest">
                        {{ $categoriaId ? 'ACTUALIZAR' : 'GUARDAR' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>