@props(['label', 'icon'])

<div class="bg-slate-50 p-5 rounded-[1.5rem] border-l-4 border-blue-600 transition-all hover:shadow-md group">
    <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-blue-600 transition-colors">
        <i class="fas {{ $icon }}"></i> {{ $label }}
    </label>
    <div class="text-slate-700 font-bold text-lg leading-tight">
        {{ $slot }}
    </div>
</div>