<div>
    <x-slot:title>Dimensi</x-slot:title>
    @include('livewire.includes.offline-alert')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dimensi
        </h2>
        {{-- <div id="content" class="mx-auto" style="max-width:500px;"> --}}
        <div class="flex flex-col md:flex-row justify-between gap-2">
            @include('livewire.includes.create-dimension-box')
            @include('livewire.includes.search-box')
        </div>
        {{-- </div> --}}
    </div>
</div>
