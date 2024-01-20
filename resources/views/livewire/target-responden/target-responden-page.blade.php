<div class="pb-16 md:pb-32">
    <x-slot:title>Buat Opsi Jawaban</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Target Responden
        </h2>
        @include('livewire.includes.targetResponden.add-target-responden')
        <!-- Cari, Hapus, Target Responden -->
        @include('livewire.includes.targetResponden.target-responden-table')
    </div>
</div>
