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
use App\Models\Entry;

class VPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $lastUpdatedTime;
    public $surveyID;
    public $dataGap = [];
    public $dataDeskripsi = [];

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
            return round($averageValue, 2);
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
            return round($averageValue, 2);
        })->values()->toArray();

        $this->dataGap['radar'] = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Harapan',
                    'data' => $rekapitulasiHarapan,
                ],
                [
                    'label' => 'Kenyataan',
                    'data' => $rekapitulasiKenyataan,
                ],
            ],
        ];

        $noDimensiRekapitulasiKenyataan = round($answersKenyataan->avg('value'), 2);
        $noDimensiRekapitulasiHarapan = round($answersHarapan->avg('value'), 2);
        $gapTemp = round($noDimensiRekapitulasiKenyataan - $noDimensiRekapitulasiHarapan, 2);
        if ($gapTemp < 0) {
            $gapKenyataan = $gapTemp * -1;
            $gapHarapan = 0;
        } else {
            $gapKenyataan = 0;
            $gapHarapan = $gapTemp;
        }

        $this->dataGap['stackedBarGap'] = [
            $nilai = [$noDimensiRekapitulasiHarapan, $noDimensiRekapitulasiKenyataan,],
            $gap = [$gapHarapan, $gapKenyataan,],
        ];

        $gapPerDimensi = [];

        foreach ($this->dataGap['radar']['labels'] as $key => $label) {
            $gap = abs($this->dataGap['radar']['datasets'][1]['data'][$key] - $this->dataGap['radar']['datasets'][0]['data'][$key]);
            $gapPerDimensi[$label] = $gap;
        }

        // getDataDeskripsi
        $survey = Survey::find($this->surveyID);
        $this->dataDeskripsi = [
            'submitted' => Entry::where('survey_id', $this->surveyID)->count(),
            'expectedRespondents' => $survey->expected_respondents,
            'surveyName' => $survey->name,
            'surveyYear' => $survey->year,
            'respondenCount' => Entry::where('survey_id', $this->surveyID)->count(),
            'expectedRespondents' => $survey->expectedRespondents,
            'dimensionData' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Harapan',
                        'data' => $rekapitulasiHarapan,
                    ],
                    [
                        'label' => 'Kenyataan',
                        'data' => $rekapitulasiKenyataan,
                    ],
                ],
            ],
            'maxGap' => ['label' => array_keys($gapPerDimensi, max($gapPerDimensi))[0], 'value' => max($gapPerDimensi)],
            'minGap' => ['label' => array_keys($gapPerDimensi, min($gapPerDimensi))[0], 'value' => min($gapPerDimensi)],
            'gapKeseluruhan' => $gapTemp,
        ];
        // dd($this->dataDeskripsi);
    }

    public function generateChart()
    {
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataGap);
    }


    public function dd()
    {
        // dd($this->all());
        $this->dispatch('chartUpdated', 8);
    }

    public function mount()
    {
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
