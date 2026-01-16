<x-filament-widgets::widget class="fi-account-widget">
    <div class="welcome-widget-card p-6 rounded-xl shadow-lg relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>

        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight mb-2" style="color: #1e3a5f; text-shadow: 1px 1px 2px rgba(255,255,255,0.5);">
                    Welcome back, {{ $this->getUserName() }}! 👋
                </h2>
                <p class="text-lg" style="color: #2d4a6f;">
                    Here's what's happening in your classes today.
                </p>
            </div>
            
            <div class="hidden md:flex items-center space-x-4 bg-white/10 backdrop-blur-md p-3 rounded-lg border border-white/20">
                <div class="text-center px-4 border-r border-white/20">
                    <span class="block text-2xl font-bold text-white">{{ date('d') }}</span>
                    <span class="text-xs text-white/70 uppercase tracking-wider">{{ date('M') }}</span>
                </div>
                <div class="text-left">
                    <span class="block text-sm font-medium text-white">{{ date('l') }}</span>
                    <span class="text-xs text-white/70">Academic Term 2024-25</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
