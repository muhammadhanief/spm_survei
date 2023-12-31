<div class="mb-4">
    @foreach ($sections as $key => $section)
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            {{-- <div class="mt-2"> --}}
            {{-- <div>
                keynya adalah {{ $key }}
            </div> --}}
            <h3>Blok {{ $key + 1 }} : {{ $section['name'] }}</h3>
            {{-- @foreach ($section as $key => $value)
                <p>{{ $key }}: {{ $value }}</p>
            @endforeach --}}

            @if (isset($section) && is_array($section))
                @foreach ($section as $qKey => $question)
                    @if (isset($question) && is_array($question))
                        <div class="mt-2">
                            <label for="question">Pertanyaan {{ $qKey + 1 }}:</label>
                            <x-button-small color="red"
                                wire:click.prevent="deleteQuestion({{ $key }}, {{ $qKey }})">Hapus
                                Pertanyaan</x-button-small>
                            <x-input-regular
                                wire:model.live='sections.{{ $key }}.{{ $qKey }}.questionName'
                                placeholder="Pertanyaan ke"></x-input-regular>
                            <x-error-display name="sections.{{ $key }}.{{ $qKey }}.questionName" />

                            <select wire:model.live='sections.{{ $key }}.{{ $qKey }}.dimensionID'
                                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="" selected>Pilih Subdimensi</option>
                                @foreach ($subdimensions as $subdimension)
                                    {{-- <option value="{{ $subdimension->id }}">{{ $subdimension->name }}</option> --}}
                                    @if ($subdimension->dimension_id == $section['sectionDimensionType'])
                                        <option value="{{ $subdimension->id }}">{{ $subdimension->name }}</option>
                                    @endif
                                    {{-- {{ $section['dimensionID'] }} --}}
                                @endforeach
                            </select>
                            <x-error-display name="sections.{{ $key }}.{{ $qKey }}.dimensionID" />

                        </div>
                    @endif
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
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Tipe dimensi di blok ini
                </span>
                <select wire:model.live='sectionDimensionType'
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" selected>Pilih tipe dimensi</option>
                    @foreach ($dimensions as $dimension)
                        <option value="{{ $dimension->id }}">{{ $dimension->name }}</option>
                    @endforeach
                </select>
                <x-error-display name="sectionDimensionType" />
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
