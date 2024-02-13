<x-mail::message>
    # Kepada {{ $name }}
    Anda mendapatkan undangan untuk mengisi survei berikut:
    <x-mail::button :url="route('survey.fill', ['surveyID' => $survey_id, 'uniqueCode' => $unique_code])">
        Isi survei
    </x-mail::button>

    Jika tombol tidak berfungsi, klik pada laman berikut
    ({{ route('survey.fill', ['surveyID' => $survey_id, 'uniqueCode' => $unique_code]) }})

    Terima kasih,
    {{ config('app.name') }}
</x-mail::message>
