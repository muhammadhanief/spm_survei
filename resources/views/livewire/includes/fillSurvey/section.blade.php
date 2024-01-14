<div class="dark:bg-purple-500 bg-purple-700 px-4 py-3 mb-8  rounded-lg shadow-md ">
    <h4 class="text-lg font-semibold dark:text-gray-300 text-gray-300">
        Blok {{ $currentSectionIndex + 1 }}. {{ $section->name }}
    </h4>
</div>
@php
    $index = 0;
@endphp
@foreach ($section->questions as $qkey => $question)
    <div wire:key='{{ $question->id }}'>
        @if ($question->questionType->name == 'Umum')
            <div class="px-4 py-3 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                        {{ $question->content }}</span>
                </label>
                @php
                    $index++;
                @endphp
                @include('livewire.includes.fillSurvey.optionType.' . $question->answeroption->type)
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

                            <div class="flex flex-row gap-x-2">
                                @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                    {{-- <p>{{ $answeroptionvalue->name }}</p> --}}
                                    <label class="inline-flex items-center text-black dark:text-gray-400">
                                        <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                            name="accountType{{ $question->id }}"
                                            value="{{ $answeroptionvalue->name }}" />
                                        <span class="ml-2">{{ $answeroptionvalue->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            {{-- <div class="flex flex-row">
                                <label class="inline-flex items-center text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Kurang Baik" />
                                    <span class="ml-2">Kurang Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Cukup Baik" />
                                    <span class="ml-2">Cukup Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Baik" />
                                    <span class="ml-2">Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Sangat Baik" />
                                    <span class="ml-2">Sangat Baik</span>
                                </label>
                            </div> --}}
                        </div>
                        <x-error-display name='answers.{{ $question->id }}.value' />
                    </div>
                </div>
            @else
                <div class="px-4 py-3 mb-4 bg-white rounded-b-lg shadow-md dark:bg-gray-800">
                    <div class="mt-2 text-sm">
                        <div class="flex flex-row gap-x-2">
                            <div class="text-black dark:text-gray-400">
                                {{ $question->questionType->name }}
                            </div>
                            <div class="flex flex-row gap-x-2">
                                @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                    {{-- <p>{{ $answeroptionvalue->name }}</p> --}}
                                    <label class="inline-flex items-center text-black dark:text-gray-400">
                                        <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                            class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                            name="accountType{{ $question->id }}"
                                            value="{{ $answeroptionvalue->name }}" />
                                        <span class="ml-2">{{ $answeroptionvalue->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            {{-- <div class="flex flex-row">
                                <label class="inline-flex items-center text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Kurang Baik" />
                                    <span class="ml-2">Kurang Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Cukup Baik" />
                                    <span class="ml-2">Cukup Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Baik" />
                                    <span class="ml-2">Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $question->id }}" value="Sangat Baik" />
                                    <span class="ml-2">Sangat Baik</span>
                                </label>
                            </div> --}}
                        </div>
                        <x-error-display name='answers.{{ $question->id }}.value' />
                    </div>
                </div>
            @endif
        @endif
    </div>
@endforeach
