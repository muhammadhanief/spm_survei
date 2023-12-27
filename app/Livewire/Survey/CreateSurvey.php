<?php

namespace App\Livewire\Survey;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

// class CreateSurvey extends Component
// {
//     public $sections = [];
//     public $currentSection = 0;
//     public $questions = [];
//     public $newSectionName = '';
//     public $showAddSectionForm = false; // Properti untuk mengontrol tampilan form


//     public function addSection()
//     {
//         $section = (object)['name' => $this->newSectionName]; // Buat objek model Section
//         $this->sections[] = $section;
//         $this->currentSection = count($this->sections) - 1;
//         $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
//         $this->showAddSectionForm = false; // Sembunyikan form setelah menambahkan bagian baru
//     }

//     public function deleteSection($index)
//     {
//         unset($this->sections[$index]);
//         unset($this->questions[$index]);
//         $this->currentSection = 0; // Pindah ke section pertama setelah menghapus
//     }

//     public function addQuestion($sectionIndex)
//     {
//         // Ambil pertanyaan yang sudah ada untuk bagian ini
//         $existingQuestions = isset($this->questions[$sectionIndex]) ? $this->questions[$sectionIndex] : [];

//         // Tambah pertanyaan baru hanya jika belum ada
//         if (empty($existingQuestions) || end($existingQuestions) !== '') {
//             $this->questions[$sectionIndex] = array_merge($existingQuestions, ['']);
//         }
//     }

//     public function deleteQuestion($sectionIndex, $questionIndex)
//     {
//         unset($this->questions[$sectionIndex][$questionIndex]);
//     }



//     #[Layout('layouts.app')]
//     public function render()
//     {
//         $Roles = Role::all();
//         return view('livewire.survey.create-survey', [
//             'Roles' => $Roles
//         ]);
//     }
// }


class CreateSurvey extends Component
{
    public $sections = [];
    public $currentSection = 0;
    public $questions = [];
    public $newSectionName = '';
    public $showAddSectionForm = false;

    public function addSection()
    {
        $section = (object)['name' => $this->newSectionName]; // Buat objek model Section
        $this->sections[] = $section;
        $this->currentSection = count($this->sections) - 1;
        $this->newSectionName = ''; // Reset nama bagian setelah menambahkan
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
        $this->questions[$key][] = '';
    }

    public function deleteQuestion($sectionIndex, $questionIndex)
    {
        array_splice($this->questions[$sectionIndex], $questionIndex, 1);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $Roles = Role::all();
        return view('livewire.survey.create-survey', [
            'Roles' => $Roles
        ]);
    }
}
