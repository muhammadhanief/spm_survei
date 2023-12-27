<div>
    <x-slot:title>Buat Survei</x-slot:title>
    <!-- resources/views/livewire/add-question.blade.php -->
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Buat Survei
        </h2>
        <!-- General elements -->
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Elements
        </h4>
        {{-- <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nama Survei</span>
                <input required
                    class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Nama Survei" />
            </label>
            <label class="block  mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Tahun</span>
                <input required type="number" min="2015" max="3000" step="1"
                    class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Tahun" />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Kategori Responden
                </span>
                <select required
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" disabled selected>Pilih Kategori Responden</option>
                    @foreach ($Roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block  mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Batasan Pengisian Per Pengguna</span>
                <input required type="number" min="1" max="100" step="1"
                    class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Batasan Pengisian Per Pengguna" />
            </label>
            <div class="flex md:flex-row flex-col gap-x-4">
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Waktu Mulai
                    </span>
                    <input required
                        class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        type="datetime-local">
                </label>
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Waktu Berakhir
                    </span>
                    <input required
                        class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        type="datetime-local">
                </label>
            </div>
        </div> --}}
        @include('livewire.includes.create-sec-quest')
    </div>
</div>
