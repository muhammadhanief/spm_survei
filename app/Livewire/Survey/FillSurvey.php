<?php

namespace App\Livewire\Survey;

use Livewire\Attributes\Layout;
use App\Models\Survey;
use App\Models\Dimension;
use App\Models\Subdimension;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FillSurvey extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';

    public function fillSurvey($surveyID)
    {
        $survey = Survey::find($surveyID);
        $started_at_parsed = \Carbon\Carbon::parse($survey->started_at);
        $ended_at_parsed = \Carbon\Carbon::parse($survey->ended_at);
        if (!$started_at_parsed->isPast() || $ended_at_parsed->isPast()) {
            // session()->flash('errorHapus', 'survey tidak dapat dihapus karena sudah dimulai');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Survey tidak dapat diisi karena belum dimulai/telah selesai',
            ]);
        } else {
            $this->redirectRoute('survey.fill', ['surveyID' => $surveyID]);
        }
    }
    public $test = '';

    public function testing()
    {
        dd($this->all());
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveys = Survey::where('name', 'like', "%{$this->search}%")
            ->orderBy('started_at', 'asc')
            ->latest()
            ->paginate(5);
        if ($surveys->isNotEmpty()) {
            return view('livewire.survey.fill-survey', [
                'surveys' => $surveys,
                'dimensions' => Dimension::all(),
                'subdimensions' => Subdimension::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Survei tidak dapat ditemukan');
            return view('livewire.survey.fill-survey', [
                'surveys' => $surveys,
                'dimensions' => Dimension::all(),
                'subdimensions' => Subdimension::all(),
            ]);
        }
    }
}
