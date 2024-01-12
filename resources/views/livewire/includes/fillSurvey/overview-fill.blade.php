<div class="px-4 py-3 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <p class="mb-4 text-3xl font-bold text-black dark:text-gray-400">
        {{ $survey->name }}
    </p>
    <p class="mb-4 text-black dark:text-gray-400">
        {!! nl2br(e($survey->description)) !!}
    </p>
</div>
