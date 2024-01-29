<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Entry;
use App\Models\TargetResponden;
use App\Models\Survey;
use App\Charts\TestLarapex;

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

    public $chart;

    public function cobaLaravelChart()
    {
        $this->chart = app()
            ->chartjs->name("UserRegistrationsChart")
            ->type("line")
            ->size(["width" => 400, "height" => 200])
            ->labels(["January", "February", "March", "April", "May", "June", "July"])
            ->datasets([
                [
                    "label" => "User Registrations",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => [65, 59, 80, 81, 56, 55, 40],
                ]
            ]);
    }

    public function mount($surveyID)
    {
        $this->surveyID = $surveyID;
        $this->getDataChart();
        $this->cobaLaravelChart();
    }


    #[Layout('layouts.app')]
    public function render(TestLarapex $chart)
    {
        $surveyID = $this->surveyID;
        return view('livewire.survey.monitoring', [
            'surveyID' => $surveyID,
            'dataChartIndividual' => $this->dataChartIndividual,
        ]);
    }
}
