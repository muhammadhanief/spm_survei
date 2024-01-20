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
            <div class="p-4 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm">
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
                <div class="p-4 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                            {{ $question->content }}</span>
                    </label>
                    @php
                        $index++;
                        $firstQuestionTypeWidth = strlen('Kenyataan') * 10;
                    @endphp
                    <div class="grid">
                        <div class="w-full grid overflow-x-auto">
                            <div class="w-full flex flex-col text-sm whitespace-no-wrap">
                                <div class="w-full flex flex-row">
                                    {{-- <p>{{ $firstQuestionTypeWidth }}</p> --}}
                                    <div
                                        class="w-20 sm:flex-1 flex items-center justify-center  p-2 text-white dark:text-gray-800 ">
                                        Kenyataan
                                    </div>
                                    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                        <div
                                            class="flex flex-1 text-center items-center justify-center  p-2 text-black dark:text-gray-400 whitespace-normal">
                                            {{ $answeroptionvalue->name }}</div>
                                    @endforeach
                                </div>
                                {{-- HARAPAN --}}
                                <div class="w-full flex flex-row">
                                    <div
                                        class="w-20 sm:flex-1 flex items-center justify-center  p-2 text-black dark:text-gray-400 bg-gray-100 dark:bg-gray-700">
                                        {{ $question->questionType->name }}
                                    </div>
                                    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                        <div
                                            class="flex-1 flex items-center justify-center  p-2 text-black dark:text-gray-400 bg-gray-100 dark:bg-gray-700">
                                            <label
                                                class="cursor-pointer w-10 h-10 bg-transparent hover:bg-white dark:hover:bg-gray-600 rounded-full flex items-center justify-center">
                                                <!-- Isi di dalam bulatan (opsional) -->
                                                <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                                    class="cursor-pointer w-4 h-4 text-purple-600 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                    name="accountType{{ $question->id }}"
                                                    value="{{ $answeroptionvalue->name }}" />
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <x-error-display name='answers.{{ $question->id }}.value' />
                                <div class="w-full flex flex-row">
                                    {{-- Akses pertanyaan pada iterasi selanjutnya, jika ada --}}
                                    {{-- INI UNTUK KENYATAAN --}}
                                    @if ($qkey + 1 < count($section->questions))
                                        <div
                                            class="w-20 sm:flex-1 flex items-center justify-center  p-2 text-black dark:text-gray-400 bg-gray-100 dark:bg-gray-700">
                                            {{ $section->questions[$qkey + 1]->questionType->name }}
                                        </div>
                                        @foreach ($section->questions[$qkey + 1]->answeroption->answeroptionvalues as $answeroptionvalue)
                                            <div
                                                class="flex-1 flex items-center justify-center  p-2 text-black dark:text-gray-400 bg-gray-100 dark:bg-gray-700">
                                                <label
                                                    class="cursor-pointer w-10 h-10 bg-transparent hover:bg-white dark:hover:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <input
                                                        wire:model='answers.{{ $section->questions[$qkey + 1]->id }}.value'
                                                        type="radio"
                                                        class="cursor-pointer w-4 h-4 text-purple-600 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $section->questions[$qkey + 1]->id }}"
                                                        value="{{ $answeroptionvalue->name }}" />
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <x-error-display name='answers.{{ $section->questions[$qkey + 1]->id }}.value' />
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        @endif
    </div>
@endforeach
