<div class="pb-16 md:pb-32">
    <x-slot:title>Isi Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Isi Survei
        </h2>
        @foreach ($survey->sections as $key => $section)
            <div wire:key='{{ $section->id }}'>
                <div class="bg-purple-300 dark:bg-purple-800 px-4 py-3 mb-8  rounded-lg shadow-md ">
                    <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                        Blok {{ $key + 1 }}. {{ $section->name }}
                    </h4>
                </div>
                @php
                    $index = 0;
                @endphp
                @foreach ($section->questions as $qkey => $question)
                    <div wire:key='{{ $question->id }}'>
                        @if ($question->questionType->name == 'Tunggal')
                            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                                        {{ $question->content }}</span>
                                </label>
                                @php
                                    $index++;
                                @endphp
                                <input wire:model='answers.{{ $question->id }}.value'
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-black dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Jawaban Anda" />
                                <x-error-display name='answers.{{ $question->id }}.value' />
                            </div>
                        @else
                            @if ($question->questionType->name == 'Harapan')
                                <div class="px-4 pt-3 bg-white rounded-t-lg shadow-md dark:bg-gray-800">
                                    <label class="block mt-4 text-sm">
                                        <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                                            {{ $question->content }}</span>
                                    </label>
                                    @php
                                        $index++;
                                    @endphp
                                    <div class="mt-2 text-sm">
                                        <div class="flex flex-row gap-x-2">
                                            <div class="text-black dark:text-gray-400">
                                                {{ $question->questionType->name }}
                                            </div>

                                            <div class="flex flex-row">
                                                <label class="inline-flex items-center text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Kurang Baik" />
                                                    <span class="ml-2">Kurang Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Cukup Baik" />
                                                    <span class="ml-2">Cukup Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Baik" />
                                                    <span class="ml-2">Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Sangat Baik" />
                                                    <span class="ml-2">Sangat Baik</span>
                                                </label>
                                            </div>
                                        </div>
                                        <x-error-display name='answers.{{ $question->id }}.value' />
                                    </div>
                                </div>
                            @else
                                <div class="px-4 py-3 mb-8 bg-white rounded-b-lg shadow-md dark:bg-gray-800">
                                    <div class="mt-2 text-sm">
                                        <div class="flex flex-row gap-x-2">
                                            <div class="text-black dark:text-gray-400">
                                                {{ $question->questionType->name }}
                                            </div>
                                            <div class="flex flex-row">
                                                <label class="inline-flex items-center text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Kurang Baik" />
                                                    <span class="ml-2">Kurang Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Cukup Baik" />
                                                    <span class="ml-2">Cukup Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Baik" />
                                                    <span class="ml-2">Baik</span>
                                                </label>
                                                <label
                                                    class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                                    <input wire:model='answers.{{ $question->id }}.value'
                                                        type="radio"
                                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $question->id }}" value="Sangat Baik" />
                                                    <span class="ml-2">Sangat Baik</span>
                                                </label>
                                            </div>
                                        </div>
                                        <x-error-display name='answers.{{ $question->id }}.value' />
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach


            </div>
        @endforeach
        <div>
            <x-button-small wire:click.prevent='create' type='submit' color="green">Submit</x-button-small>
        </div>
    </div>
</div>
