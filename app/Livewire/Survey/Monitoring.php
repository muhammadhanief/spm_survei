<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Entry;
use App\Models\TargetResponden;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Mail\RespondenSurveyAnnounceFirst;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Monitoring extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $surveyID;
    public $dataChartIndividual = [];
    public $search = '';
    public $lastUpdatedTime;

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
    }

    public function getUpdatedDataChart()
    {
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataChartIndividual);
    }

    public function updateTable()
    {
        $this->render();
    }

    public function updateAll()
    {
        $this->updateTable();
        // ambil waktu terakhir update
        $this->lastUpdatedTime = now()->format('H:i:s');
        $this->getUpdatedDataChart();
    }

    // Properti untuk melacak progres
    public $sendingProgress = 0;
    public $totalEmails = 0;
    public $successCount = 0;
    public $errorCount = 0;
    public $errorMessage = '';

    // ...

    public function sendEmailReminder()
    {
        $targetRespondens = DB::table('target_respondens')
            ->leftJoin('entries', function ($join) {
                $join->on('target_respondens.id', '=', 'entries.target_responden_id')
                    ->where('entries.survey_id', '=', $this->surveyID);
            })
            ->where('target_respondens.type', '=', 'individual')
            ->select(
                'target_respondens.*',
                DB::raw('CASE WHEN entries.target_responden_id IS NOT NULL THEN true ELSE false END as submitted')
            )
            ->orderBy('name')->get();

        $this->totalEmails = count($targetRespondens);

        $error = [];

        foreach ($targetRespondens as $targetResponden) {
            if ($targetResponden->submitted == false) {
                try {
                    Mail::to($targetResponden->email)->send(new RespondenSurveyAnnounceFirst([
                        'email' => $targetResponden->email,
                        'name' => $targetResponden->name,
                        'unique_code' => $targetResponden->unique_code,
                        'survey_id' => $this->surveyID,
                        'survey_title' => Survey::find($this->surveyID)->name,
                    ]));

                    // Update progres
                    $this->successCount++;
                } catch (\Exception $e) {
                    $error[] = $e->getMessage();
                    // Update progres
                    $this->errorCount++;
                    $this->errorMessage = $e->getMessage();
                }

                // Update progres
                $this->sendingProgress = ($this->successCount + $this->errorCount) / $this->totalEmails * 100;
            }
        }

        // Setelah selesai, tampilkan alert berdasarkan hasil
        if (count($error) == 0) {
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Email sukses dikirim.',
            ]);
            $this->reset('sendingProgress', 'totalEmails', 'successCount', 'errorCount', 'errorMessage');
        } else {
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => true,
                'text' => 'Gagal mengirim email: ' . $this->errorMessage,
            ]);
        }
    }

    public function mount($surveyID)
    {
        $this->surveyID = $surveyID;
        $this->getDataChart();
        $this->lastUpdatedTime = now()->format('H:i:s');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveyID = $this->surveyID;
        // $targetRespondens = TargetResponden::whereIn('role_id', json_decode(Survey::find($surveyID)->role_id))->paginate(20);
        $targetRespondens = DB::table('target_respondens')
            ->leftJoin('entries', function ($join) {
                $join->on('target_respondens.id', '=', 'entries.target_responden_id')
                    ->where('entries.survey_id', '=', $this->surveyID);
            })
            ->where('target_respondens.type', '=', 'individual')
            ->where('name', 'like', "%{$this->search}%")
            ->select(
                'target_respondens.*',
                DB::raw('CASE WHEN entries.target_responden_id IS NOT NULL THEN true ELSE false END as submitted')
            )
            ->orderBy('name')
            ->paginate(10);
        return view('livewire.survey.monitoring', [
            'surveyID' => $surveyID,
            'targetRespondens' => $targetRespondens,
            'lastUpdatedTime' => $this->lastUpdatedTime,
        ]);
    }
}
