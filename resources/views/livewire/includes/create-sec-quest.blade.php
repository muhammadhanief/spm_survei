<div class="mb-4">
    @foreach ($sections as $key => $section)
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            {{-- <div class="mt-2"> --}}
            <div>
                keynya adalah {{ $key }}
            </div>
            <h3>Blok {{ $key + 1 }} : {{ $section->name }}</h3>
            @if (isset($questions[$key]) && is_array($questions[$key]))
                @foreach ($questions[$key] as $qKey => $question)
                    <div class="mt-2">
                        <label for="question">Pertanyaan {{ $qKey + 1 }}:</label>
                        <x-button-small color="red"
                            wire:click="deleteQuestion({{ $key }}, {{ $qKey }})">Hapus
                            Pertanyaan</x-button-small>
                        <x-input-regular wire:model="questions.{{ $key }}.{{ $qKey }}"
                            placeholder="Question {{ $qKey + 1 }}"></x-input-regular>
                    </div>
                @endforeach
            @endif
            <x-button-small color="blue" wire:click="addQuestion({{ $key }})">Tambah
                Pertanyaan di Blok ini</x-button-small>
            <x-button-small color="red" wire:click="deleteSection({{ $key }})">Hapus
                Blok</x-button-small>
            {{-- </div> --}}
        </div>
    @endforeach
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        @if ($showAddSectionForm)
            <div class="mt-2">
                <label for="newSectionName" class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Blok</span>
                    <x-input-regular required wire:model="newSectionName" placeholder="Nama Blok"></x-input-regular>
                </label>
                <x-button-small class="mt-4" wire:click="addSection" color="purple">
                    Tambah Blok +
                </x-button-small>
            </div>
        @else
            <x-button-small wire:click="$toggle('showAddSectionForm')" color="blue">
                Buat Blok Baru
            </x-button-small>
        @endif
    </div>
</div>
