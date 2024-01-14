<div class="flex flex-row gap-x-2">
    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
        {{-- <p>{{ $answeroptionvalue->name }}</p> --}}
        <label class="inline-flex items-center text-black dark:text-gray-400">
            <input wire:model='answers.{{ $question->id }}.value' type="radio"
                class="text-sm text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                name="accountType{{ $question->id }}" value="{{ $answeroptionvalue->name }}" />
            <span class="text-sm ml-2">{{ $answeroptionvalue->name }}</span>
        </label>
    @endforeach
</div>
<x-error-display name='answers.{{ $question->id }}.value' />
