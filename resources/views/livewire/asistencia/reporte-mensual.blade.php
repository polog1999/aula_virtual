<div class="p-4 md:p-8">
    @section('vista', 'Reporte Mensual')

    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-black text-gray-800 mb-6 uppercase tracking-wider">Reporte de Asistencia Mensual</h1>

        {{-- Filtros robustos --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Periodo</label>
                    <select wire:model.live="periodo_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Seleccione...</option>
                        @foreach($periodos as $p) <option value="{{ $p->id }}">{{ $p->anio }} - {{ $p->ciclo }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Categoría</label>
                    <select wire:model.live="categoria_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Seleccione...</option>
                        @foreach($categorias as $c) <option value="{{ $c->id }}">{{ $c->nombre }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Curso</label>
                    <select wire:model.live="curso_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-green-500" {{ !$categoria_id ? 'disabled' : '' }}>
                        <option value="">Seleccione...</option>
                        @foreach($cursos as $cu) <option value="{{ $cu->id }}">{{ $cu->nombre }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Sección</label>
                    <select wire:model.live="seccion_id" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-green-500" {{ !$curso_id ? 'disabled' : '' }}>
                        <option value="">Seleccione...</option>
                        @foreach($secciones as $s) <option value="{{ $s->id }}">{{ $s->nombre }} ({{ $s->dia_semana }})</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Mes</label>
                    <select wire:model.live="mes" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-green-500">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ Carbon\Carbon::create()->month($m)->locale('es')->monthName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button wire:click="generarReporte" class="bg-blue-700 hover:bg-blue-800 text-white px-8 py-2.5 rounded-xl font-black text-xs transition-all shadow-lg shadow-blue-200 uppercase tracking-widest">
                    <i class="fa fa-sync mr-2"></i> Generar Matriz
                </button>
            </div>
        </div>

        {{-- La Tabla que enviaste integrada --}}
        @if(!empty($estudiantesReporte))
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-in fade-in duration-500">
            <div class="overflow-x-auto">
                <table class="w-full text-[11px] text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 font-bold uppercase border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 sticky left-0 bg-gray-100 z-10 border-r min-w-[200px]">Participante | Fecha</th>
                            @foreach($diasDelMes as $fechaClase)
                                <th class="px-2 py-3 text-center border-r">{{ \Carbon\Carbon::parse($fechaClase)->day }}</th>
                            @endforeach
                            <th class="px-4 py-3 text-left bg-blue-50 text-blue-700 min-w-[150px]">Resumen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($estudiantesReporte as $est)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-4 py-2 font-bold uppercase sticky left-0 bg-white z-10 border-r shadow-[2px_0_5px_rgba(0,0,0,0.05)]">
                                {{ $est->apellido_paterno }} {{ $est->nombres }}
                            </td>
                            @foreach($diasDelMes as $fechaClase)
                                @php 
                                    $dia = \Carbon\Carbon::parse($fechaClase)->day; 
                                    $estado = $est->asistencias_por_dia[$dia] ?? null; 
                                @endphp
                                <td class="px-2 py-2 text-center border-r font-black">
                                    @if($estado == 'ASISTIO') <span class="text-green-500">✔</span>
                                    @elseif($estado == 'FALTO') <span class="text-red-500">✖</span>
                                    @elseif($estado == 'TARDANZA') <span class="text-yellow-500">T</span>
                                    @else <span class="text-gray-200">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-2 bg-blue-50/30">
                                <div class="flex items-center gap-2">
                                    @php 
                                        $p = $est->porcentaje_asistencia;
                                        $color = $p >= 80 ? 'text-green-600' : ($p >= 60 ? 'text-yellow-600' : 'text-red-600');
                                    @endphp
                                    <span class="font-black {{ $color }} text-xs">{{ number_format($p, 1) }}%</span>
                                    <div class="text-[9px] text-gray-500 leading-tight">
                                        A:{{ $est->total_asistencias }} F:{{ $est->total_faltas }} T:{{ $est->total_tardanzas }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>