<header class="bg-black text-white">
    <div class="mx-auto max-w-5xl items-center justify-between flex px-6 py-5">
        <a href="{{ route('tasks.index') }}" class="flex items-center gap-3">
            <span class="flex-col flex hover:text-white/80">
                <span class="font-bold text-lg uppercase tracking-wider">
                    Astra Report
                </span>
                <span class="text-[12px] text-white/40">
                    Tahun 2026
                </span>
            </span>
        </a>

        <nav class="flex items-center gap-6 text-sm font-semibold">
            <a href="{{ route('tasks.index') }}" class="hover:text-white/70">Task</a>
            <a href="{{ route('dealers.index') }}" class="hover:text-white/70">Dealer</a>
            
            {{-- Department dan Area hanya bisa diakses oleh Supervisor --}}
            @if(auth()->user()->role === 'supervisor')
                <a href="{{ route('departments.index') }}" class="hover:text-white/70">Department</a>
                <a href="{{ route('areas.index') }}" class="hover:text-white/70">Area</a>
            @endif
        </nav>

        <div class="flex items-center gap-4">
            <div class="text-right text-xs">
                <span class="block font-bold text-amber-400 uppercase">
                    {{ auth()->user()->role }}
                </span>
                <span class="text-white/60">
                    {{ auth()->user()->name }}
                </span>
            </div>

            <form 
                method="POST" 
                action="{{ route('logout') }}" 
                class="bg-amber-500 border py-1.5 px-3 rounded-lg text-sm font-bold border-amber-600 hover:bg-amber-600 text-black">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>