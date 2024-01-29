<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Entry;
use App\Models\TargetResponden;
use App\Models\Survey;



class Monitoring extends Component
{
    public $surveyID;
    public $dataChartIndividual = [];

    public function getDataChart()
    {
        $submittedIndividual = Entry::where('survey_id', $this->surveyID)
            ->whereHas('targetResponden', function ($query) {
                $query->where('type', 'individual');
            })
            ->count();
        $survey = Survey::find($this->surveyID);
        $totalRespondenIndividual = TargetResponden::whereIn('role_id', json_decode($survey->role_id))
            ->where('type', 'individual')
            ->count();
        $this->dataChartIndividual = [
            'Telah Mengisi' => $submittedIndividual,
            'Belum Mengisi' => $totalRespondenIndividual - $submittedIndividual,
        ];

        $this->dispatch('chartUpdated', $this->dataChartIndividual);
        // mau commit ini takut abis amend
        // mau commit ini takut abis amend
    }

    public function mount($surveyID)
    {
        $this->surveyID = $surveyID;
        $this->getDataChart();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveyID = $this->surveyID;
        return view('livewire.survey.monitoring', [
            'surveyID' => $surveyID,
            'dataChartIndividual' => $this->dataChartIndividual,
        ]);
    }
}
