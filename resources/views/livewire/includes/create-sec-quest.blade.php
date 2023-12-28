<div class="mb-4">
    @foreach ($sections as $key => $section)
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            {{-- <div class="mt-2"> --}}
            {{-- <div>
                keynya adalah {{ $key }}
            </div> --}}
            <h3>Blok {{ $key + 1 }} : {{ $section->name }}</h3>
            @if (isset($questions[$key]) && is_array($questions[$key]))
                @foreach ($questions[$key] as $qKey => $question)
                    <div class="mt-2">
                        <label for="question">Pertanyaan {{ $qKey + 1 }}:</label>
                        <x-button-small color="red"
                            wire:click.prevent="deleteQuestion({{ $key }}, {{ $qKey }})">Hapus
                            Pertanyaan</x-button-small>
                        <x-input-regular wire:model="questions.{{ $key }}.{{ $qKey }}"
                            placeholder="Question {{ $qKey + 1 }}"></x-input-regular>
                    </div>
                @endforeach
            @endif
            <x-button-small color="blue" wire:click.prevent="addQuestion({{ $key }})">Tambah
                Pertanyaan di Blok ini</x-button-small>
            <x-button-small color="red" wire:click.prevent="deleteSection({{ $key }})">Hapus
                Blok</x-button-small>
            {{-- </div> --}}
        </div>
    @endforeach
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        @if ($showAddSectionForm)
            <div class="mt-2">
                <label for="newSectionName" class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Blok</span>
                    <x-input-regular required wire:model.live="newSectionName"
                        placeholder="Nama Blok"></x-input-regular>
                </label>
                <x-error-display name="newSectionName" />
            </div>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Tipe pertanyaan di blok ini
                </span>
                <select wire:model.live='sectionQuestionType'
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" selected>Pilih tipe pertanyaan</option>
                    <option value="tunggal">Tipe Tunggal</option>
                    <option value="harapanDanKenyataan">Tipe Harapan dan Kenyataan</option>
                </select>
                <x-error-display name="sectionQuestionType" />
            </label>
            <x-button-small class="mt-4" wire:click.prevent="addSection" color="purple">
                Tambah Blok +
            </x-button-small>
            <x-button-small class="mt-4" wire:click.prevent="cancelSection" color="red">
                Cancel
            </x-button-small>
        @else
            <x-button-small wire:click.prevent="$toggle('showAddSectionForm')" color="blue">
                Buat Blok Baru
            </x-button-small>
            @if (session('successAddSection'))
                <span class="text-green-600 dark:text-green-400 text-xs mt-3">{{ session('successAddSection') }}</span>
            @endif
        @endif
    </div>
</div>
