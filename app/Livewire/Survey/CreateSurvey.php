<?php

namespace App\Livewire\Survey;

use App\Models\Survey;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use App\Models\Dimension;

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

    public $questions = [];

    public $showAddSectionForm = false;

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
        $section = (object)[
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
        unset($this->sections[$index]);
        unset($this->questions[$index]);
        $this->currentSection = 0;
        $this->sections = array_values($this->sections);
        $this->questions = array_values($this->questions);
    }

    public function addQuestion($key)
    {
        $newQuestion = [
            'questionName' => '',
            'sectionID' => $key,
            'dimensionID' => '',
        ];
        $this->questions[$key][] = $newQuestion;
    }

    public function deleteQuestion($sectionIndex, $questionIndex)
    {
        array_splice($this->questions[$sectionIndex], $questionIndex, 1);
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

        Survey::create([
            'name' => $this->name,
            'description' => $this->description,
            'year' => $this->year,
            'role_id' => $this->roleIdParticipant,
            'settings' => ['limit-per-participant' => $this->limitPerParticipant],
            'started_at' => $this->startAt,
            'ended_at' => $this->endAt,
        ]);

        $this->reset();
        session()->flash('successAdd', 'Survey sukses ditambahkan.');
    }

    public function testDD()
    {
        // dd($this->all());
        // dd($this->sections[0]->name);
        // $this->section[0]->sectionQuestionType = 'test';
        // $this->questions[0][0]->questionName
        dd($this->all(), $this->sections[0]->sectionQuestionType);
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
