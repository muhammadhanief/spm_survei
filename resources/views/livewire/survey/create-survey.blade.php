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
        <form>
            @include('livewire.includes.create-overview-survey')
            @include('livewire.includes.create-sec-quest')
            <div>
                <x-button-small wire:click.prevent='create' type="submit" color="green">Submit</x-button-small>
                {{-- <button wire:click.prevent='create' type="submit"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Tambah
                Dimensi
                +</button> --}}
            </div>

            <x-button-small wire:click.prevent='testDD' type="submit" color="red">Test DD</x-button-small>
        </form>

    </div>
</div>
