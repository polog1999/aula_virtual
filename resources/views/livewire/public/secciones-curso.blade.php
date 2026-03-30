<div class="min-h-screen bg-[#e6edef] font-sans">
    {{-- Header --}}
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="text-[#3a348b] font-black text-xl leading-none uppercase tracking-tighter">INSN</span>
                        <span class="text-[#9d2581] text-[10px] font-bold uppercase">Líder en Pediatría</span>
                    </div>
                </a>
                <nav>
                    <a href="{{ route('login') }}" class="px-6 py-2.5 bg-white border-2 border-[#00aba4] text-[#00aba4] font-bold rounded-full hover:bg-[#00aba4] hover:text-white transition-all duration-300">
                        INGRESAR
                    </a>
                </nav>
            </div>
        </div>
        <div class="h-1.5 w-full flex">
            <div class="h-full w-1/4 bg-[#ffcd00]"></div>
            <div class="h-full w-1/4 bg-[#9d2581]"></div>
            <div class="h-full w-1/4 bg-[#00aba4]"></div>
            <div class="h-full w-1/4 bg-[#3a348b]"></div>
        </div>
    </header>

    <main>
        {{-- Banner Dinámico --}}
        <section class="relative h-64 md:h-80 flex items-center justify-center overflow-hidden">
            <img src="{{ asset('storage/' . $disciplina->imagen) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $disciplina->nombre }}">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
            
            <div class="relative z-10 text-center px-4">
                <nav class="mb-4">
                    <a href="/" class="text-[#ffcd00] hover:text-white text-sm font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition-colors">
                        <i class="fa-solid fa-arrow-left-long"></i> Volver al Catálogo
                    </a>
                </nav>
                <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tight">{{ $disciplina->nombre }}</h1>
                <p class="text-gray-200 mt-2 font-medium">Selecciona el horario que mejor se adapte a tus necesidades</p>
            </div>
        </section>

        {{-- Filtros --}}
        <section class="max-w-7xl mx-auto px-4 -mt-10 relative z-20">
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100 flex flex-col md:flex-row gap-4">
                <div class="flex-grow relative">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre de sección..." 
                           class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-[#00aba4]/20 font-bold text-gray-600">
                </div>
                <div class="md:w-72">
                    <select wire:model.live="selectedCategory" 
                            class="w-full px-4 py-3.5 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-[#00aba4]/20 font-bold text-gray-600 cursor-pointer">
                        <option value="todos">Todas las categorías</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        {{-- Listado de Secciones --}}
        <section class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($secciones as $seccion)
                    <div class="bg-white rounded-[2.5rem] shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden flex flex-col group">
                        <div class="p-8 flex-grow">
                            {{-- Header Card --}}
                            <div class="flex justify-between items-start mb-6">
                                <span class="px-4 py-1.5 bg-[#eef2f3] text-[#3a348b] text-[10px] font-black rounded-xl uppercase tracking-wider">
                                    {{ $seccion->curso->categoria->nombre }}
                                </span>
                                <div class="flex flex-col items-end">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Periodo</span>
                                    <span class="text-[#9d2581] font-bold">{{ $seccion->periodo->anio }} - {{ $seccion->periodo->ciclo }}</span>
                                </div>
                            </div>

                            <h3 class="text-xl font-black text-[#3a348b] uppercase leading-tight mb-6 group-hover:text-[#00aba4] transition-colors">
                                Sección: {{ $seccion->nombre }}
                            </h3>

                            {{-- Detalles --}}
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-4 group/item">
                                    <div class="w-10 h-10 rounded-xl bg-[#00aba4]/10 flex items-center justify-center text-[#00aba4]">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase leading-none">Horarios</p>
                                        <p class="text-sm font-bold text-gray-700 uppercase">{{ $seccion->dia_semana }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#9d2581]/10 flex items-center justify-center text-[#9d2581]">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase leading-none">Docente</p>
                                        <p class="text-sm font-bold text-gray-700 uppercase">
                                            {{ $seccion->docentes?->user ? $seccion->docentes->user->nombres . ' ' . $seccion->docentes->user->apellido_paterno : 'Por asignar' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Barra de Vacantes --}}
                            <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-black text-gray-500 uppercase">Cupos Disponibles</span>
                                    <span class="text-sm font-black {{ $seccion->matriculas_activas_count >= $seccion->vacantes ? 'text-red-500' : 'text-[#00aba4]' }}">
                                        {{ $seccion->matriculas_activas_count }}/{{ $seccion->vacantes }}
                                    </span>
                                </div>
                                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full {{ $seccion->matriculas_activas_count >= $seccion->vacantes ? 'bg-red-500' : 'bg-[#00aba4]' }} transition-all duration-1000" 
                                         style="width: {{ min(($seccion->matriculas_activas_count / max($seccion->vacantes, 1)) * 100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card / Botón --}}
                        <div class="p-2">
                            @if($seccion->matriculas_activas_count >= $seccion->vacantes)
                                <button disabled class="w-full py-4 bg-gray-100 text-gray-400 font-black uppercase rounded-[2rem] cursor-not-allowed flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-lock"></i> Cupos Agotados
                                </button>
                            @else
                                <a href="{{ route('form.inscripciones', $seccion->id) }}" 
                                   class="w-full py-4 bg-[#3a348b] hover:bg-[#00aba4] text-white font-black uppercase rounded-[2rem] transition-all duration-300 shadow-lg hover:shadow-[#00aba4]/40 flex items-center justify-center gap-2 active:scale-95">
                                    Inscribirme Ahora <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-4 border-dashed border-gray-100">
                        <i class="fa-solid fa-calendar-xmark text-6xl text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-bold uppercase tracking-widest">No se encontraron secciones disponibles</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $secciones->links() }}
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-gray-200 py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">
                &copy; {{ date('Y') }} Instituto Nacional de Salud del Niño - OEAIIDE
            </p>
        </div>
    </footer>
</div>