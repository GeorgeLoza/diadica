{{-- Notificación de error --}}
    @session('error')
        <div x-data="{ show: true }" x-show="show"
            class="fixed bottom-6 right-6 z-50 w-96 p-4 bg-red-600 text-white text-sm border border-red-300 dark:border-red-700 rounded-xl shadow-xl transition-opacity duration-300 flex items-center gap-3"
            role="alert">
            <i class="fa fa-exclamation-triangle text-lg"></i>
            <span class="flex-1">{{ $value }}</span>
            <button @click="show = false" class="ml-2 px-2 py-1 rounded hover:bg-red-700 transition">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endsession

    {{-- Notificación de éxito --}}
    @session('success')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 3000)"
            class="fixed bottom-6 right-6 z-50 w-96 p-4 bg-green-600 text-white text-sm border border-green-300 dark:border-green-700 rounded-xl shadow-xl transition-opacity duration-300 flex items-center gap-3"
            role="alert">
            <i class="fa fa-check-circle text-lg"></i>
            <span class="flex-1">{{ $value }}</span>
            <button @click="show = false" class="ml-2 px-2 py-1 rounded hover:bg-green-700 transition">
                <i class="fa fa-times"></i>
            </button>
        </div>
    @endsession