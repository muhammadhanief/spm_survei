<?php

namespace App\Livewire\Survey;

use Livewire\Attributes\Layout;
use App\Models\Survey;
use Livewire\Component;
use App\Models\Question;
use App\Models\Answer;
use Livewire\Attributes\Validate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FillSurveyDetail extends Component
{
    use LivewireAlert;
    public $surveyID;
    public $answers = [];

    // Fungsi mount digunakan untuk menginisialisasi komponen dengan parameter rute.
    public function mount($surveyID)
    {
        $this->surveyID = $surveyID;
        $questions = Question::where('survey_id', $this->surveyID)->get();
        foreach ($questions as $question) {
            $this->answers[$question->id] = [
                'question_id' => $question->id,
                'value' => '',
                'question_type_id' => '',
            ];
        }
    }

    public function setQuestionTypeID()
    {
        foreach ($this->answers as $key => $answer) {
            $questionModel = Question::find($key);
            $this->answers[$key]['question_id'] = $key;
            $this->answers[$key]['question_type_id'] = $questionModel->questionType->id;
        }
    }

    public function validateAnswer()
    {
        // $answerArrayRule = [];
        // foreach ($this->answers as $key => $answers) {
        //     $answerArrayRule['answers.' . $key .  '.value'] = 'required';
        // }

        $answerArrayRule = [
            'answers' => 'required|array',
            'answers.*.value' => 'required',
        ];
        $messages = [
            'required' => 'Pertanyaan wajib diisi.',
            'answers.required' => 'The :attribute are missing.',
        ];
        $attributes = [
            'answers.*.value' => 'answer',
        ];

        // Cek apakah $secQuesArrayRule kosong
        if (empty($answerArrayRule)) {
            // Aturan validasi kosong, maka tampilkan pesan kesalahan
            return false;
        } else {
            // Validasi dengan aturan yang telah dibuat
            $this->validate($answerArrayRule, $messages, $attributes);
            return true;
        }
    }

    public function save()
    {
        foreach ($this->answers as $key => $answer) {
            Answer::create([
                'question_id' => $answer['question_id'],
                'value' => $answer['value'],
                'question_type_id' => $answer['question_type_id'],
            ]);
        }
    }

    public function create()
    {
        $this->setQuestionTypeID();
        if ($this->validateAnswer()) {
            $this->save();
            $tempSurveyID = $this->surveyID;
            $tempAnswers = $this->answers;
            $this->reset();
            $this->surveyID = $tempSurveyID;
            $this->mount($this->surveyID);
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Jawaban sukses dikumpulkan.',
            ]);
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Jawaban gagal dikumpulkan.',
            ]);
        }
    }

    // untuk section yang dipisah
    public $currentSectionIndex = -1;
    public $survey;

    public function nextSection()
    {
        // Validasi sebelum pindah ke bagian berikutnya
        // $rules = [
        //     'answers' => 'required|array',
        // ];
        if ($this->currentSectionIndex != -1) {
            $validationRules = [];
            $messages = [];
            // // Tambahkan aturan validasi untuk setiap pertanyaan pada bagian saat ini
            foreach ($this->survey->sections[$this->currentSectionIndex]->questions as $question) {
                $validationRules['answers.' . $question->id . '.value'] = 'required';
                // $rules['answers.' . $question->id . '.value'] = "required";
                // $messages['required'] = 'Pertanyaan wajib diisi.';
                $messages['answers.' . $question->id . '.value.required'] = 'Pertanyaan wajib diisi.';
            }

            // dd($rules, $this->answers);
            $this->validate($validationRules, $messages);
        }
        // Pindah ke bagian berikutnya jika validasi berhasil
        if ($this->currentSectionIndex < count($this->survey->sections) - 1) {
            $this->currentSectionIndex++;
        }
    }

    public function previousSection()
    {
        if ($this->currentSectionIndex > -1) {
            $this->currentSectionIndex--;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // $surveyID = request()->route('surveyID');
        $surveyID = $this->surveyID;
        $survey = Survey::find($surveyID);
        $this->survey = $survey;
        if ($survey) {
            // Redirect or provide a proper response for non-existing surveyID
            return view('livewire.survey.fill-survey-detail', ['survey' => $survey]);
        } else {
            return view('errors.404');
        }
    }
}
