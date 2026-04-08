<div class="p-4 md:p-8">
    @section('vista', 'Usuarios')

    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Gestión de Usuarios</h1>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50">
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Buscar usuario..." 
                           class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm transition-all font-medium">
                </div>
                
                <button wire:click="openModal()" 
                        class="w-full md:w-auto px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transform active:scale-95 transition-all flex items-center justify-center gap-2 text-xs">
                    <i class="fa fa-plus"></i> CREAR NUEVO USUARIO
                </button>
            </div>

            {{-- Tabla --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-600 uppercase bg-gray-100 font-bold">
                        <tr>
                            <th class="px-6 py-4">Nombres Completo</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Documento</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4">Rol(es)</th>
                            <th class="px-6 py-4 w-32 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users_list as $user)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 uppercase leading-tight">
                                        {{ $user->nombres }} {{ $user->apellido_paterno }} {{ $user->apellido_materno }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] font-black text-gray-400 block uppercase">{{ $user->tipo_documento }}</span>
                                    <span class="font-bold text-gray-700">{{ $user->numero_documento }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $user->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-[9px] font-black uppercase border border-indigo-200">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <button wire:click="openModal({{ $user->id }})" 
                                            class="p-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button onclick="confirmarAccion('deleteUser', {{ $user->id }}, '¿Eliminar usuario?')" 
                                            class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition" title="Eliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No se encontraron usuarios.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $users_list->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    @if($isOpen)
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl mx-4 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="px-6 py-4 bg-gray-800 text-white flex justify-between items-center">
                <h2 class="text-lg font-bold uppercase tracking-tight">{{ $userId ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
                <button wire:click="$set('isOpen', false)" class="text-white/70 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Nombre</label>
                        <input type="text" wire:model="nombres" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold uppercase">
                        @error('nombres') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Apellidos</label>
                        <input type="text" wire:model="apellido_paterno" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold uppercase">
                    </div>
                    {{-- <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Ap. Materno</label>
                        <input type="text" wire:model="apellido_materno" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold uppercase">
                    </div> --}}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Tipo Doc.</label>
                        <select wire:model="tipo_documento" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                            <option value="">Elegir...</option>
                            <option value="DNI">DNI</option>
                            <option value="CE">CE</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">N° Documento</label>
                        <input type="text" wire:model="numero_documento" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                        @error('numero_documento') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Estado</label>
                        <select wire:model="activo" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">Email (Usuario para el sistema)</label>
                    <input type="email" wire:model="email" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                    @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Asignar Roles</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($all_roles as $role)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" wire:model="roles_seleccionados" value="{{ $role->name }}" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                            <span class="text-xs font-bold text-gray-600 group-hover:text-blue-600 uppercase">{{ $role->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('roles_seleccionados') <span class="text-red-500 text-[10px] font-bold block mt-2">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('isOpen', false)" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition text-xs tracking-widest uppercase">CANCELAR</button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-700 text-white rounded-xl font-bold hover:bg-blue-800 shadow-lg transform active:scale-95 transition-all text-xs tracking-widest uppercase">{{ $userId ? 'ACTUALIZAR' : 'GUARDAR' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>