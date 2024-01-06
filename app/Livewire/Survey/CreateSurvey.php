<?php

namespace App\Livewire\Survey;

use App\Models\Survey;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use App\Models\Dimension;
use App\Models\Question;
use App\Models\Section;
use App\Models\Subdimension;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateSurvey extends Component
{
    use LivewireAlert;
    #[Validate(['required', 'min:5'])]
    public $name = '';
    #[Validate(['required', 'min:5'])]
    public $description = '';
    #[Validate(['required', 'numeric', 'digits:4'])]
    public $year = '';
    #[Validate(['required', 'numeric', 'gt:0'])]
    public $limitPerParticipant = '';
    #[Validate(['required', 'numeric', 'min:1', 'not_in:'])]
    public $roleIdParticipant = '';
    #[Validate(['required', 'after_or_equal:now'])]
    public $startAt = '';
    #[Validate(['required', 'after:startAt'])]
    public $endAt = '';

    // Temporary variables for section and question
    #[Validate('required|min:3')]
    public $newSectionName = '';
    #[Validate('required|not_in:')]
    public $sectionQuestionType = '';
    #[Validate('required|not_in:')]
    public $sectionDimensionType = '';
    // public $newQuestionName = '';
    // public $newDimensionID = '';


    public $sections = [];
    public $currentSection = 0;

    public $showAddSectionForm = false;

    public $surveyID;


    public function rules()
    {
        $arraySection = [];
        foreach ($this->sections as $key => $section) {
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    $arraySection['sections.' . $key . '.' . $key2 . '.questionName'] = 'required';
                    $arraySection['sections.' . $key . '.' . $key2 . '.sectionID'] = 'required';
                    $arraySection['sections.' . $key . '.' . $key2 . '.dimensionID'] = 'required';
                }
            }
        }
        // dd($arraySection);

        $cobaRule = [
            'name' => [
                'required',
                'min:5',
            ],
            'description' => [
                'required',
                'min:5',
            ],
            'year' => [
                'required',
                'numeric', 'digits:4',
            ],
            'limitPerParticipant' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'roleIdParticipant' => [
                'required',
                'numeric',
                'min:1',
                'not_in:'
            ],
            'startAt' => [
                'required',
                'after_or_equal:now',
            ],
            'endAt' => [
                'required',
                'after:startAt'
            ],
        ];
        $mergedArray = array_merge($cobaRule, $arraySection);
        return $cobaRule;
        // dd($cobaRule, $arraySection, $mergedArray);
    }

    public function addSection()
    {
        $addSectionRule = [
            'newSectionName' => [
                'required', 'min:3',
            ],
            'sectionQuestionType' => [
                'required', 'not_in:',

            ],
            'sectionDimensionType' => [
                'required', 'not_in:',
            ],

        ];
        $this->validate($addSectionRule);
        $section = [
            'name' => $this->newSectionName,
            'sectionQuestionType' => $this->sectionQuestionType,
            'sectionDimensionType' => $this->sectionDimensionType,
        ]; // Buat objek model Section
        $this->sections[] = $section;
        $this->currentSection = count($this->sections) - 1;
        // $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
        $this->showAddSectionForm = false; // Sembunyikan form setelah menambahkan bagian baru
        $this->reset('sectionQuestionType', 'newSectionName');
        session()->flash('successAddSection', 'Blok sukses ditambahkan.');
    }

    public function cancelSection()
    {
        // $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
        $this->reset('newSectionName');
        $this->showAddSectionForm = false; // Sembunyikan form setelah menambahkan bagian baru
    }

    public function deleteSection($index)
    {
        $this->currentSection = 0;
        array_splice($this->sections, $index, 1);
    }

    public function addQuestion($key)
    {
        $this->sections[$key][] = [
            'questionName' => '',
            'sectionID' => $key,
            'dimensionID' => '',
        ];
        // $this->questions[$key][] = $newQuestion;
    }

    public function deleteQuestion($sectionIndex, $questionIndex)
    {
        unset($this->sections[$sectionIndex][$questionIndex]);
        // Mengurutkan ulang indeks kunci
        $this->sections[$sectionIndex] = array_merge($this->sections[$sectionIndex]);
        // $this->sections[$sectionIndex] = array_values($this->sections[$sectionIndex]);
    }

    public function validateSurvey()
    {
        $surveyArrayRule = [
            'name' => [
                'required',
                'min:5',
            ],
            'description' => [
                'required',
                'min:5',
            ],
            'year' => [
                'required',
                'numeric', 'digits:4',
            ],
            'roleIdParticipant' => [
                'required',
                'numeric',
                'min:1',
                'not_in:'
            ],
            'limitPerParticipant' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'startAt' => [
                'required',
                'after_or_equal:now',
            ],
            'endAt' => [
                'required',
                'after:startAt'
            ],
        ];

        $this->validate($surveyArrayRule);
    }

    public function createSurvey()
    {
        $this->validateSurvey();
        $survey = Survey::create([
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'role_id' => $this->roleIdParticipant,
            'settings' => ['limit-per-participant' => $this->limitPerParticipant],
            'started_at' => $this->startAt,
            'ended_at' => $this->endAt,
        ]);
        $this->surveyID = $survey->id;
    }


    public function validateSectionAndQuestion()
    {
        $secQuesArrayRule = [];
        foreach ($this->sections as $key => $section) {
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.questionName'] = 'required';
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.sectionID'] = 'required';
                    $secQuesArrayRule['sections.' . $key . '.' . $key2 . '.dimensionID'] = 'required';
                }
            }
        }
        // Cek apakah $secQuesArrayRule kosong
        if (empty($secQuesArrayRule)) {
            // Aturan validasi kosong, maka tampilkan pesan kesalahan
            return false;
        } else {
            // Validasi dengan aturan yang telah dibuat
            $this->validate($secQuesArrayRule);
            return true;
        }

        // $this->validate($secQuesArrayRule);
    }

    public function createSectionAndQuestion()
    {
        // Validasi dan simpan Section
        // dd($this->sections);
        foreach ($this->sections as $key => $section) {
            $createdSection = Section::create([
                'name' => $section[$key]['questionName'],
                'survey_id' => $this->surveyID,
            ]);
            $createdSectionID = $createdSection->id;
            // Validasi dan simpan Question
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    // if else for different question type based on sectionQuestionType
                    if ($this->sections[$key]['sectionQuestionType'] == 'tunggal') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '1',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                    } elseif ($this->sections[$key]['sectionQuestionType'] == 'harapanDanKenyataan') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '2',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'subdimension_id' => $question['dimensionID'],
                            'question_type_id' => '3',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                    }
                }
            }
        }
    }


    public function create()
    {
        $this->validateSurvey();
        if ($this->validateSectionAndQuestion()) {
            $this->createSurvey();
            $this->createSectionAndQuestion();
            $this->reset();
            // session()->flash('successAdd', 'Survey sukses ditambahkan.');
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey sukses ditambahkan.',
            ]);
        } else {
            session()->flash('failedAdd', 'Survey gagal ditambahkan karena question gada samsek. buat question lalu submit ulang');
        }
    }

    // public function testDDReal()
    // {
    //     $arraySection = [];
    //     foreach ($this->sections as $key => $section) {
    //         foreach ($section as $key2 => $question) {
    //             if (is_numeric($key2)) {
    //                 $arraySection['sections.' . $key . '.' . $key2 . '.questionName'] = 'required';
    //                 $arraySection['sections.' . $key . '.' . $key2 . '.sectionID'] = 'required';
    //                 $arraySection['sections.' . $key . '.' . $key2 . '.dimensionID'] = 'required';
    //             }
    //         }
    //     }
    //     // dd($arraySection);

    //     $cobaRule = [
    //         'name' => [
    //             'required',
    //             'min:5',
    //         ],
    //         'description' => [
    //             'required',
    //             'min:5',
    //         ],
    //         'year' => [
    //             'required',
    //             'numeric', 'digits:4',
    //         ],
    //         'limitPerParticipant' => [
    //             'required',
    //             'numeric',
    //             'gt:0'
    //         ],
    //         'roleIdParticipant' => [
    //             'required',
    //             'numeric',
    //             'min:1',
    //             'not_in:'
    //         ],
    //         'startAt' => [
    //             'required',
    //             'after_or_equal:now',
    //         ],
    //         'endAt' => [
    //             'required',
    //             'after:startAt'
    //         ],
    //     ];
    //     $mergedArray = array_merge($cobaRule, $arraySection);
    //     dd($cobaRule, $arraySection, $mergedArray);
    // }

    public function testDD()
    {
        // $this->create();
        // $lastIDSurvey = Survey::latest()->first()->id;
        // Filter array to keep only numeric keys

        // foreach ($this->sections as $key => $section) {
        //     $createdSection = Section::create([
        //         'name' => $section['name'],
        //         'survey_id' => $this->surveyID,
        //     ]);
        //     $createdSectionID = $createdSection->id;
        //     foreach ($section as $key2 => $question) {
        //         if (is_numeric($key2)) {
        //             // if else for diferent question type based on sectionQuestionType
        //             if ($section['sectionQuestionType'] == 'tunggal') {
        //                 Question::create([
        //                     'survey_id' => $this->surveyID,
        //                     'section_id' => $createdSectionID,
        //                     'dimension_id' => $question['dimensionID'],
        //                     'question_type_id' => '1',
        //                     'content' => $question['questionName'],
        //                     'type' => 'text',
        //                 ]);
        //             } else if ($section['sectionQuestionType'] == 'harapanDanKenyataan') {
        //                 Question::create([
        //                     'survey_id' => $this->surveyID,
        //                     'section_id' => $createdSectionID,
        //                     'dimension_id' => $question['dimensionID'],
        //                     'question_type_id' => '2',
        //                     'content' => $question['questionName'],
        //                     'type' => 'text',
        //                 ]);
        //                 Question::create([
        //                     'survey_id' => $this->surveyID,
        //                     'section_id' => $createdSectionID,
        //                     'dimension_id' => $question['dimensionID'],
        //                     'question_type_id' => '3',
        //                     'content' => $question['questionName'],
        //                     'type' => 'text',
        //                 ]);
        //             }
        //         }
        //     }
        // }
        // $this->reset();
        // dd($keykey);

        // foreach ($this->sections as $key => $section) {
        //     Section::create([
        //         'name' => $section->name,
        //         'survey_id' => $lastIDSurvey,
        //     ]);
        // }

        // $questions = [];
        // foreach ($this->questions as $key => $question) {
        //     foreach ($question as $key2 => $question2) {
        //         if ($question->sectionQuestionType == 'tunggal') {
        //             $questions[] = [
        //                 'content' => $question2['questionName'],
        //                 'section_id' => $question2['sectionID'],
        //                 'dimension_id' => $question2['dimensionID'],
        //                 'type' => 'text',
        //             ];
        //         }
        //     }
        // }
        // $this->sections[0][0]['questionName'] = 'coba masukin nama section di dalam questions';
        // dd($this->sections);

        // dd($this->all(), $this->sections[0]->sectionQuestionType);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.survey.create-survey', [
            'roles' => Role::all(),
            'dimensions' => Dimension::all(),
            'subdimensions' => Subdimension::all(),
        ]);
    }
}
