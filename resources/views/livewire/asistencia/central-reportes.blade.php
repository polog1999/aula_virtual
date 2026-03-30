<div class="p-4 md:p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-black text-gray-800 mb-2 uppercase">Central de Reportes</h1>
        <p class="text-gray-500 mb-8 font-medium">Genera archivos consolidados en formato Excel para auditoría y control.</p>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 bg-blue-700 text-white flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-2xl">
                    <i class="fa fa-file-excel"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Reporte Consolidado de Asistencias</h3>
                    <p class="text-blue-100 text-xs">Historial completo de todas las secciones del periodo.</p>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 text-sm text-blue-800 italic">
                    <strong>Nota:</strong> Este proceso analiza miles de registros. La descarga puede tardar unos segundos dependiendo de la cantidad de alumnos matriculados.
                </div>

                <div class="form-group">
                    <label class="block text-xs font-black text-gray-400 uppercase mb-2">Selecciona el Periodo Académico</label>
                    <select wire:model="periodo_id" class="w-full border border-gray-300 rounded-xl p-4 text-sm font-bold focus:ring-4 focus:ring-blue-100 outline-none transition-all">
                        <option value="">-- Elige un periodo --</option>
                        @foreach($periodos as $p)
                            <option value="{{ $p->id }}">{{ $p->anio }} - {{ $p->ciclo }}</option>
                        @endforeach
                    </select>
                </div>

                <button wire:click="descargarExcel" class="w-full py-4 bg-blue-700 hover:bg-blue-800 text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-3 active:scale-95">
                    <i class="fa fa-download text-lg"></i> Iniciar Descarga (.xlsx)
                </button>
            </div>
        </div>
    </div>
</div>