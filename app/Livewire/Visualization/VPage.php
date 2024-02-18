<?php

namespace App\Livewire\Visualization;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Subdimension;

class VPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $lastUpdatedTime;
    public $surveyID;
    public $dataRadar = [];

    public function getDataChart()
    {
        $questionHarapan = Question::where('survey_id', $this->surveyID)->where('question_type_id', 2)->get();
        $answersHarapan = Answer::whereIn('question_id', $questionHarapan->pluck('id'))->get();

        $answersHarapan = $answersHarapan->map(function ($answer) use ($questionHarapan) {
            $subdimensionId = $questionHarapan->where('id', $answer->question_id)->pluck('subdimension_id')->first();
            $answer->subdimension_id = $subdimensionId;
            return $answer;
        });

        $rekapitulasiHarapan = $answersHarapan->groupBy('subdimension_id')->map(function ($answers) {
            $totalValue = $answers->sum('value');
            $averageValue = $totalValue / $answers->count();
            return $averageValue;
        })->values()->toArray();

        $labels = Subdimension::whereIn('id', $questionHarapan->pluck('subdimension_id'))->orderBy('id')->pluck('name')->toArray();

        $questionKenyataan = Question::where('survey_id', $this->surveyID)->where('question_type_id', 3)->get();
        $answersKenyataan = Answer::whereIn('question_id', $questionKenyataan->pluck('id'))->get();

        $answersKenyataan = $answersKenyataan->map(function ($answer) use ($questionKenyataan) {
            $subdimensionId = $questionKenyataan->where('id', $answer->question_id)->pluck('subdimension_id')->first();
            $answer->subdimension_id = $subdimensionId;
            return $answer;
        });

        $rekapitulasiKenyataan = $answersKenyataan->groupBy('subdimension_id')->map(function ($answers) {
            $totalValue = $answers->sum('value');
            $averageValue = $totalValue / $answers->count();
            return $averageValue;
        })->values()->toArray();

        // dd($rekapitulasiHarapan);
        $this->dataRadar = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'data' => $rekapitulasiHarapan,
                    'fill' => true,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'pointBackgroundColor' => 'rgb(255, 99, 132)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(255, 99, 132)',
                ],
                [
                    'label' => 'My Second Dataset',
                    'data' => $rekapitulasiKenyataan,
                    'fill' => true,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'pointBackgroundColor' => 'rgb(54, 162, 235)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(54, 162, 235)',
                ],
            ],
        ];
        // dd($this->dataRadar);
    }

    // public function updatedsurveyID()
    // {
    //     $this->getDataChart();
    //     $this->dispatch('chartUpdated', $this->dataRadar);
    // }

    public function generateChart()
    {
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataRadar);
    }

    // public function updated($property)
    // {
    //     if ($property == 'surveyID') {
    //         $this->getDataChart();
    //     }
    // }

    public function dd()
    {
        // dd($this->all());
        $this->dispatch('chartUpdated', 8);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.visualization.v-page', [
            'surveys' => Survey::all(),
            'lastUpdatedTime' => $this->lastUpdatedTime,
        ]);
    }
}
