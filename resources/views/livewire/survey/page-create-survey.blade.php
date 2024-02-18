<div class="pb-16 md:pb-32">
    <x-slot:title>Buat Survei</x-slot:title>

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Buat Survei
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300 text-center">
            Bagaimana Anda akan membuat survei?
        </h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <a href="{{ route('survey.create') }}"
                class="min-w-0 p-4 bg-white hover:bg-slate-100 transform transition duration-500 ease-in-out hover:scale-105 rounded-lg shadow-xs dark:bg-gray-800 dark:hover:bg-gray-700">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Mulai dari Awal
                </h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Pilih menu ini jika belum pernah ada survei yang sama di tahun sebelumnya.
                </p>
                {{-- >Buat Survei Baru --}}
            </a>

            <a href="{{ route('survey.copy') }}"
                class="min-w-0 p-4 text-white bg-purple-600 dark:hover:bg-purple-500 hover:bg-purple-700 transform transition duration-500 ease-in-out hover:scale-105 rounded-lg shadow-xs">
                <h4 class="mb-4 font-semibold">
                    Salin Survey yang Sudah Ada
                </h4>
                <p>
                    Pilih menu ini jika sudah ada survei yang sama di tahun sebelumnya.
                    Anda tetap bisa mengedit pertanyaan yang ada pada survei sebelumnya.
                </p>
            </a>
        </div>
    </div>
</div>
