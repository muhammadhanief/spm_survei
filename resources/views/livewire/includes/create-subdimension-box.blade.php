<div class="w-full">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Tambah Subdimensi
    </h4>
    <div class="px-4 py-3  bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-6">
                <label class="block  text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih Dimensi
                    </span>
                    <select wire:model.live='dimensionID'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Dimensi Induk</option>
                        @foreach ($dimensions as $dimension)
                            <option value="{{ $dimension->id }}">{{ $dimension->name }}</option>
                        @endforeach
                    </select>
                    <x-error-display name="dimensionID" />
                </label>
                <label class="block text-sm mt-2">
                    <span class="text-gray-700 dark:text-gray-400">Nama Subdimensi</span>
                    <input wire:model.live="subdimensionName" type="text" id="subdimensionName"
                        placeholder="Nama Subdimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('subdimensionName')
                        <div class="text-red-600 dark:text-red-400  text-xs mt-3">{{ $message }}</div>
                    @enderror
                </label>
                <label class="block text-sm mt-2">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi Subdimensi</span>
                    <input wire:model.live="subdimensionDescription" type="text" id="subdimensionDescription"
                        placeholder="Deskripsi Subdimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('subdimensionDescription')
                        <div class="text-red-600 dark:text-red-400  text-xs mt-3">{{ $message }}</div>
                    @enderror
                </label>
                @if (session('success'))
                    <span class="text-green-600 dark:text-green-400 text-xs mt-3">{{ session('success') }}</span>
                @endif
            </div>
            <x-button-small wire:click.prevent='createSubdimension' type="submit" color="purple">Tambah Subdimensi
                +</x-button-small>
        </form>
    </div>
</div>
