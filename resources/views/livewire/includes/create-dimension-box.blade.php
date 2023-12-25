<div class="w-full">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Tambah Dimensi
    </h4>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-6">
                <input wire:model.live="name" type="text" id="name" placeholder="Nama Dimensi"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                @error('name')
                    <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                @enderror
            </div>
            <button wire:click.prevent='create' type="submit"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Tambah
                Dimensi
                +</button>
            @if (session('success'))
                <span class="text-green-500 text-xs">{{ session('success') }}</span>
            @endif
        </form>
    </div>
</div>
