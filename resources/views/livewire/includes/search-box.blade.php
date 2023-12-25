<div class="w-full">
    <!-- Cari, Hapus, Edit Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Cari, Hapus, Edit Dimensi
    </h4>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800  ">
        <div id="search-box" class="flex flex-col items-center px-2 my-4 justify-center">
            <!-- Search input -->
            <div class="flex justify-start lg:mr-32">
                <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500 ">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d=" M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                    <input
                        class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                        wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Dimensi.." />
                </div>
            </div>
            @if (session('gagalSearch'))
                <span class="text-red-500 text-xs pt-2">{{ session('gagalSearch') }}</span>
            @endif
            @if (session('successHapus'))
                <span class="text-green-500 text-xs pt-2">{{ session('successHapus') }}</span>
            @else
                <span class="text-red-500 text-xs pt-2">{{ session('errorHapus') }}</span>
            @endif
        </div>
        @include('livewire.includes.dimensions-card')
    </div>
</div>
