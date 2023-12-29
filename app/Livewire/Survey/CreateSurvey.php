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

class CreateSurvey extends Component
{
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

    // public $newQuestionName = '';
    // public $newDimensionID = '';


    public $sections = [];
    public $currentSection = 0;

    public $showAddSectionForm = false;

    public $surveyID;

    public function rules()
    {
        return [
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
    }

    public function addSection()
    {
        // dd($this->all());
        $this->validateOnly('sectionQuestionType');
        $this->validateOnly('newSectionName');
        $section = [
            'name' => $this->newSectionName,
            'sectionQuestionType' => $this->sectionQuestionType,
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



    public function create()
    {
        $this->validateOnly('name');
        $this->validateOnly('description');
        $this->validateOnly('year');
        $this->validateOnly('roleIdParticipant');
        $this->validateOnly('limitPerParticipant');
        $this->validateOnly('startAt');
        $this->validateOnly('endAt');

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

        // $this->reset();
        // session()->flash('successAdd', 'Survey sukses ditambahkan.');
    }

    public function testDD()
    {
        $this->create();
        // $lastIDSurvey = Survey::latest()->first()->id;
        // Filter array to keep only numeric keys

        foreach ($this->sections as $key => $section) {
            $createdSection = Section::create([
                'name' => $section['name'],
                'survey_id' => $this->surveyID,
            ]);
            $createdSectionID = $createdSection->id;
            foreach ($section as $key2 => $question) {
                if (is_numeric($key2)) {
                    // if else for diferent question type based on sectionQuestionType
                    if ($section['sectionQuestionType'] == 'tunggal') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'dimension_id' => $question['dimensionID'],
                            'question_type_id' => '1',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                    } else if ($section['sectionQuestionType'] == 'harapanDanKenyataan') {
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'dimension_id' => $question['dimensionID'],
                            'question_type_id' => '2',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                        Question::create([
                            'survey_id' => $this->surveyID,
                            'section_id' => $createdSectionID,
                            'dimension_id' => $question['dimensionID'],
                            'question_type_id' => '3',
                            'content' => $question['questionName'],
                            'type' => 'text',
                        ]);
                    }
                }
            }
        }
        $this->reset();
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
        ]);
    }
}
