<div class="p-4 md:p-8">
    {{-- Inyección de estilos y título --}}
    @section('vista', 'Periodos')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/admin/talleres.css') }}">
        <link rel="stylesheet" href="{{ asset('css/paginacion-buscador.css') }}">
    @endpush

    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Gestión de Periodos</h1>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header: Buscador y Botón --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                <div class="relative w-full md:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Buscar por ciclo..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-sm">
                </div>
                
                <button wire:click="openModal()" 
                        class="w-full md:w-auto px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2">
                    <i class="fa fa-plus"></i> NUEVO PERIODO
                </button>
            </div>

            {{-- Tabla con anchos fijos para evitar el descuadre --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th class="px-6 py-4 w-20">Año</th>
                            <th class="px-6 py-4">Ciclo / Nombre</th>
                            <th class="px-6 py-4 w-32 text-center">F. Inicio</th>
                            <th class="px-6 py-4 w-32 text-center">F. Fin</th>
                            <th class="px-6 py-4 w-40 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($periodos as $periodo)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $periodo->anio }}</td>
                                <td class="px-6 py-4 text-gray-700 font-semibold">{{ $periodo->ciclo }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $periodo->fecha_inicio->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center text-gray-600">{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <button wire:click="openModal({{ $periodo->id }})" 
                                            class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button onclick="confirmarEliminar({{ $periodo->id }})" 
                                            class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition" title="Eliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">No se encontraron registros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer de Paginación --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $periodos->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TOTALMENTE CENTRADO Y TRANSPARENTE --}}
    @if($isModalOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-transparent">
        <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
            {{-- Header Modal --}}
            <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold">{{ $periodoId ? 'Editar Registro' : 'Nuevo Registro' }}</h2>
                <button wire:click="$set('isModalOpen', false)" class="text-white/70 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Año</label>
                        <input type="number" wire:model="anio" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ciclo</label>
                        <input type="text" wire:model="ciclo" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">F. Inicio</label>
                        <input type="date" wire:model="fecha_inicio" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">F. Fin</label>
                        <input type="date" wire:model="fecha_fin" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="$set('isModalOpen', false)" 
                            class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition">
                        CANCELAR
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2.5 bg-blue-700 text-white rounded-lg font-bold hover:bg-blue-800 shadow-lg transition">
                        {{ $periodoId ? 'ACTUALIZAR' : 'GUARDAR' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>