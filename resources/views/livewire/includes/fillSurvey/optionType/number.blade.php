<input wire:model='answers.{{ $question->id }}.value'
    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-black dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
    placeholder="Jawaban Anda" type="number" />
<x-error-display name='answers.{{ $question->id }}.value' />
