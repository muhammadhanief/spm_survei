<div class="w-full">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Tambah Dimensi
    </h4>
    <div class="px-4 py-3  bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-6">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Dimensi</span>
                    <input wire:model.live="name" type="text" id="name" placeholder="Nama Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('name')
                        <div class="text-red-600 dark:text-red-400  text-xs mt-3">{{ $message }}</div>
                    @enderror
                </label>
                <label class="block text-sm mt-2">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi Dimensi</span>
                    <input wire:model.live="description" type="text" id="description" placeholder="Deskripsi Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('description')
                        <div class="text-red-600 dark:text-red-400  text-xs mt-3">{{ $message }}</div>
                    @enderror
                </label>

                @if (session('success'))
                    <span class="text-green-600 dark:text-green-400 text-xs mt-3">{{ session('success') }}</span>
                @endif

            </div>
            <button wire:click.prevent='create' type="submit"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Tambah
                Dimensi
                +</button>
        </form>
    </div>
</div>
