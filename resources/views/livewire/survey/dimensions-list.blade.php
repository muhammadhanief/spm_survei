<div>
    <x-slot:title>Dimensi</x-slot:title>
    @include('livewire.includes.offline-alert')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dimensi
        </h2>
        <div class="flex flex-col  justify-between md:gap-2">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="md:w-1/2 mb-2 md:mb-0">
                    @include('livewire.includes.create-dimension-box')
                </div>
                <div class="md:w-1/2 mb-2 md:mb-0">
                    @include('livewire.includes.create-subdimension-box')
                </div>
            </div>
            @include('livewire.includes.search-box')
        </div>
    </div>
</div>
