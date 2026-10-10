<header class="bg-black text-white">
    <div class="mx-auto max-w-4xl items-center justify-between flex px-6 py-5">
        <a class="flex items-center gap-3">
            <span class="flex-col flex hover:text-white/80">
                <span class="font-bold text-lg uppercase ">
                    Astra Report 
                </span>
                <span class="text-[12px] text-white/40">
                    Tahun 2026
                </span>
            </span>
        </a>

        <nav class="flex gap-5 text-sm font-semibold ">
            <a href="{{ route('dealers.index') }}" class="hover:text-white/55">Dealer</a>
            <a href="{{ route('departments.index') }}" class="hover:text-white/55">Department</a>
            <a href="{{ route('areas.index') }}" class="hover:text-white/55">Area</a>
            <a href="{{ route('tasks.index') }}" class="hover:text-white/55">Task</a>
        </nav>

        <form 
            method="POST" 
            action="{{ route('logout') }}" 
            class="bg-amber-500 border py-2 px-3 rounded-lg font-bold border-black hover:bg-amber-500/60">
            <button type="submit">Logout</button>
        </form>
        
    </div>
</header>