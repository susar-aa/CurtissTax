<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open"
            type="button"
            class="flex items-center space-x-2 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-neutral-900 border border-neutral-800 text-neutral-300 hover:text-white hover:border-neutral-700 transition shadow-sm">
        <i data-lucide="globe" class="w-3.5 h-3.5 text-neutral-400"></i>
        <span>{{ $supportedLocales[app()->getLocale()]['native'] ?? 'English' }}</span>
        <i data-lucide="chevron-down" class="w-3 h-3 text-neutral-500"></i>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-1.5 w-40 rounded-lg bg-neutral-900 border border-neutral-800 py-1 shadow-xl z-50 divide-y divide-neutral-800/60"
         style="display: none;">
        @foreach($supportedLocales as $code => $info)
            <a href="{{ route('locale.set', $code) }}"
               class="flex items-center justify-between px-3 py-2 text-xs font-medium hover:bg-neutral-800 transition {{ app()->getLocale() === $code ? 'text-white bg-neutral-800/60 font-semibold' : 'text-neutral-400 hover:text-white' }}">
                <span class="flex items-center space-x-2">
                    <span>{{ $info['flag'] }}</span>
                    <span>{{ $info['native'] }}</span>
                </span>
                @if(app()->getLocale() === $code)
                    <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                @endif
            </a>
        @endforeach
    </div>
</div>
