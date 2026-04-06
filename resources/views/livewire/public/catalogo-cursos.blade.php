<div class="min-h-screen bg-[#e6edef] font-sans">
    {{-- Header Institucional --}}
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <img src="{{asset('storage/logo/LOGO-INSN-2022.png')}}" alt="Logo INSN" style="width:120px" >
                    </div>
                </a>

                <!-- Botón Login -->
                <nav>
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-6 py-2.5 bg-white border-2 border-[#00aba4] text-[#00aba4] font-bold rounded-full hover:bg-[#00aba4] hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fa-solid fa-user-circle"></i>
                        INGRESAR
                    </a>
                </nav>
            </div>
        </div>
        {{-- Barra de colores decorativa --}}
        <div class="h-1.5 w-full flex">
            <div class="h-full w-1/4 bg-[#ffcd00]"></div>
            <div class="h-full w-1/4 bg-[#9d2581]"></div>
            <div class="h-full w-1/4 bg-[#00aba4]"></div>
            <div class="h-full w-1/4 bg-[#3a348b]"></div>
        </div>
    </header>

    <main>
        {{-- Hero Section --}}
        <section class="relative bg-[#3a348b] py-20 overflow-hidden">
            {{-- Elementos decorativos de fondo --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#9d2581] opacity-20 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-[#ffcd00] opacity-20 rounded-full -ml-10 -mb-10"></div>
            
            <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
                <h2 class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tight uppercase">
                    Aula Virtual <span class="text-[#ffcd00]">INSN</span>
                </h2>
                <p class="text-indigo-100 text-lg md:text-xl max-w-2xl mx-auto mb-10 font-medium">
                    Plataforma de capacitación continua de la Oficina Ejecutiva de Apoyo a la Investigación y Docencia Especializada.
                </p>
                
                {{-- Buscador Flotante --}}
                <div class="max-w-2xl mx-auto relative group">
                    <input type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="¿Qué curso estás buscando hoy?" 
                        class="w-full pl-14 pr-6 py-5 bg-white rounded-2xl shadow-2xl focus:ring-4 focus:ring-[#00aba4]/30 border-none text-gray-700 font-bold text-lg transition-all outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-[#00aba4] text-xl"></i>
                </div>
            </div>
        </section>

        {{-- Grid de Cursos --}}
        <section class="max-w-7xl mx-auto px-4 py-16">
            <div class="flex items-center justify-between mb-10 border-b border-gray-200 pb-5">
                <h3 class="text-2xl font-black text-[#3a348b] uppercase tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-graduation-cap text-[#00aba4]"></i>
                    Cursos Disponibles
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($disciplinas as $disciplina)
                    <div class="group bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col transform hover:-translate-y-2 border border-gray-100">
                        {{-- Imagen con Badge --}}
                        <div class="h-52 relative overflow-hidden">
                            <img src="{{ asset('storage/' . $disciplina->imagen) }}" 
                                 alt="{{ $disciplina->nombre }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <span class="absolute top-4 right-4 bg-[#ffcd00] text-[#3a348b] font-black text-[10px] px-3 py-1 rounded-full uppercase shadow-sm">
                                Nuevo
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="p-6 flex-grow flex flex-col">
                            <h4 class="text-lg font-black text-[#3a348b] leading-tight mb-3 uppercase group-hover:text-[#9d2581] transition-colors">
                                {{ $disciplina->nombre }}
                            </h4>
                            
                            <p class="text-gray-500 text-sm line-clamp-3 mb-6 font-medium">
                                {{ $disciplina->descripcion_corta ?? 'Fortalece tus conocimientos con nuestra plana docente especializada.' }}
                            </p>

                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Secciones</span>
                                    <span class="text-[#00aba4] font-bold">{{ $disciplina->talleres_count }} Activas</span>
                                </div>
                                <a href="{{ route('talleres.show', ['disciplina' => $disciplina->id]) }}" 
                                   class="bg-[#3a348b] hover:bg-[#9d2581] text-white p-3 rounded-xl transition-all shadow-md active:scale-90">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white/50 rounded-3xl border-4 border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-gray-300 mb-4">
                            <i class="fa-solid fa-book-open text-4xl"></i>
                        </div>
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm">No hay cursos disponibles para tu búsqueda</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $disciplinas->links() }}
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex justify-center gap-8 mb-8 text-[#00aba4] text-xl">
                <a href="#" class="hover:text-[#9d2581] transition-colors"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="hover:text-[#9d2581] transition-colors"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="hover:text-[#9d2581] transition-colors"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">
                &copy; {{ date('Y') }} Instituto Nacional de Salud del Niño - OEAIIDE
            </p>
        </div>
    </footer>

    {{-- SweetAlert2 Notificaciones --}}
    @script
    <script>
        $wire.on('swal', (event) => {
            const data = event[0];
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                confirmButtonColor: '#00aba4',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold uppercase text-sm'
                }
            });
        });
    </script>
    @endscript
</div>