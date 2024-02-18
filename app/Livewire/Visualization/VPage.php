<?php

namespace App\Livewire\Visualization;

use App\Models\Survey;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class VPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $lastUpdatedTime;
    public $surveyID;
    public $dataRadar = [];

    public function updated($property)
    {
        if ($property == 'surveyID') {
            $this->updateChart();
        }
    }

    public function getDataChart()
    {
        $this->dataRadar = [
            'labels' => ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'data' => [65, 59, 90, 81, 56, 55, 40],
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
                    'data' => [28, 48, 40, 19, 96, 27, 100],
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
    }

    public function test()
    {
        // dd($this->all());
        $this->dispatch('chartUpdated', $this->dataRadar);
    }

    public function updateChart()
    {
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataRadar);
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
