<div class="p-4 md:p-8">
    @section('vista', 'Registro de Asistencia')
    
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-gray-800 mb-6 uppercase tracking-wider">Control de Asistencia Diaria</h1>

        {{-- Panel de Filtros --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">1. Periodo</label>
                    <select wire:model.live="periodo_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none font-semibold">
                        <option value="">Seleccione...</option>
                        @foreach($periodos as $p) <option value="{{ $p->id }}">{{ $p->anio }} - {{ $p->ciclo }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">2. Categoría</label>
                    <select wire:model.live="categoria_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none font-semibold">
                        <option value="">Seleccione...</option>
                        @foreach($categorias as $c) <option value="{{ $c->id }}">{{ $c->nombre }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">3. Curso</label>
                    <select wire:model.live="curso_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none font-semibold" {{ !$categoria_id ? 'disabled' : '' }}>
                        <option value="">Seleccione...</option>
                        @foreach($cursos as $cu) <option value="{{ $cu->id }}">{{ $cu->nombre }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">4. Sección / Horario</label>
                    <select wire:model.live="seccion_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none font-semibold" {{ !$curso_id ? 'disabled' : '' }}>
                        <option value="">Seleccione...</option>
                        @foreach($secciones as $s) 
                            <option value="{{ $s->id }}">{{ $s->nombre }} ({{ $s->dia_semana }}) - {{ $s->docentes->user->nombres }}</option> 
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">5. Fecha de Clase</label>
                    <select wire:model.live="fecha" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none font-semibold" {{ !$seccion_id ? 'disabled' : '' }}>
                        <option value="">Elegir fecha...</option>
                        @foreach($fechas as $f) <option value="{{ $f }}">{{ \Carbon\Carbon::parse($f)->format('d/m/Y') }}</option> @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button wire:click="buscarAlumnos" class="px-8 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg shadow-md transition-all flex items-center gap-2">
                    <i class="fa fa-search"></i> CARGAR LISTADO
                </button>
            </div>
        </div>

        {{-- Listado de Alumnos --}}
        @if(!empty($estudiantes))
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-in fade-in duration-500">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-700 uppercase text-sm">Lista de Participantes</h3>
                <div class="flex gap-4 text-xs font-bold">
                    <span class="flex items-center gap-1 text-green-600"><span class="w-3 h-3 bg-green-500 rounded-full"></span> P: Presente</span>
                    <span class="flex items-center gap-1 text-yellow-600"><span class="w-3 h-3 bg-yellow-500 rounded-full"></span> T: Tardanza</span>
                    <span class="flex items-center gap-1 text-red-600"><span class="w-3 h-3 bg-red-500 rounded-full"></span> F: Falta</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-[10px] font-black">
                        <tr>
                            <th class="px-6 py-4 w-12">N°</th>
                            <th class="px-6 py-4">Apellidos y Nombres</th>
                            <th class="px-6 py-4 w-64 text-center">Estado de Asistencia</th>
                            <th class="px-6 py-4">Observaciones (Opcional)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($estudiantes as $index => $est)
                        <tr class="hover:bg-blue-50/20 transition-colors">
                            <td class="px-6 py-4 text-gray-400 font-bold">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700 uppercase">{{ $est['nombre_completo'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <label class="cursor-pointer group">
                                        <input type="radio" wire:model="asistencias_data.{{ $est['matricula_id'] }}.estado" value="ASISTIO" class="hidden peer">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-200 peer-checked:bg-green-500 peer-checked:border-green-500 peer-checked:text-white font-black transition-all group-hover:border-green-300">P</span>
                                    </label>
                                    <label class="cursor-pointer group">
                                        <input type="radio" wire:model="asistencias_data.{{ $est['matricula_id'] }}.estado" value="TARDANZA" class="hidden peer">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-200 peer-checked:bg-yellow-500 peer-checked:border-yellow-500 peer-checked:text-white font-black transition-all group-hover:border-yellow-300">T</span>
                                    </label>
                                    <label class="cursor-pointer group">
                                        <input type="radio" wire:model="asistencias_data.{{ $est['matricula_id'] }}.estado" value="FALTO" class="hidden peer">
                                        <span class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-200 peer-checked:bg-red-500 peer-checked:border-red-500 peer-checked:text-white font-black transition-all group-hover:border-red-300">F</span>
                                    </label>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($asistencias_data[$est['matricula_id']]['estado'] !== 'ASISTIO')
                                <input type="text" wire:model="asistencias_data.{{ $est['matricula_id'] }}.detalles" 
                                       placeholder="Ej: Justificó falta..." 
                                       class="w-full border-b border-gray-300 focus:border-blue-500 outline-none py-1 text-sm bg-transparent animate-in slide-in-from-left-2 duration-300">
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 border-t flex justify-end">
                <button wire:click="guardarAsistencia" class="px-10 py-3 bg-green-600 hover:bg-green-700 text-white font-black rounded-xl shadow-lg transform active:scale-95 transition-all flex items-center gap-2 uppercase tracking-widest text-xs">
                    <i class="fa fa-save text-lg"></i> Finalizar y Guardar
                </button>
            </div>
        </div>
        @endif
    </div>
</div>