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
use Livewire\Attributes\Validate;

class Monitoring extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $surveyID;
    public $dataChartIndividual = [];
    public $search = '';
    public $lastUpdatedTime;
    #[Validate]
    public $expectedRespondents;

    public function rules()
    {
        return [
            'expectedRespondents' => 'required|numeric',
        ];
    }

    public function getDataChart()
    {
        $submittedIndividual = Entry::where('survey_id', $this->surveyID)
            // ->whereHas('targetResponden', function ($query) {
            //     $query->where('type', 'individual');
            // })
            ->count();
        $survey = Survey::find($this->surveyID);
        // $totalRespondenIndividual = TargetResponden::whereIn('role_id', json_decode($survey->role_id))
        //     ->where('type', 'individual')
        //     ->count();
        $totalRespondenIndividual = $this->expectedRespondents;

        // Hitung jumlah yang belum mengisi
        $belumMengisi = $totalRespondenIndividual - $submittedIndividual;

        // Jika jumlah yang belum mengisi menjadi negatif, atur menjadi 0
        $belumMengisi = max(0, $belumMengisi);

        // Assign data ke dalam array
        $this->dataChartIndividual = [
            'Telah Mengisi' => $submittedIndividual,
            'Belum Mengisi' => $belumMengisi,
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

    public function updateExpectedResponden()
    {
        $this->validate([
            'expectedRespondents' => 'required|numeric',
        ]);
        $survey = Survey::find($this->surveyID);
        $survey->expectedRespondents = $this->expectedRespondents;
        $this->getDataChart();
        $this->dispatch('chartUpdated', $this->dataChartIndividual);
        $survey->save();

        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Jumlah target responden berhasil diperbaharui.',
        ]);
    }

    public function sendEmailReminder()
    {
        $targetRespondens = DB::table('target_respondens')
            ->leftJoin('entries', function ($join) {
                $join->on('target_respondens.id', '=', 'entries.target_responden_id')
                    ->where('entries.survey_id', '=', $this->surveyID);
            })
            // ->where('target_respondens.type', '=', 'individual')
            ->select(
                'target_respondens.*',
                DB::raw('CASE WHEN entries.target_responden_id IS NOT NULL THEN true ELSE false END as submitted')
            )
            ->orderBy('name')->get();

        $this->totalEmails = count($targetRespondens);

        $error = [];

        foreach ($targetRespondens as $targetResponden) {
            if ($targetResponden->submitted == false || $targetResponden->type == "group") {
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
        $expectedRespondentsTemp = Survey::find($surveyID)->expectedRespondents;
        if ($expectedRespondentsTemp == null) {
            $this->expectedRespondents = 0;
        } else {
            $this->expectedRespondents = $expectedRespondentsTemp;
        }
        $this->getDataChart();
        $this->lastUpdatedTime = now()->format('H:i:s');
    }


    public function copyLink()
    {
        $this->dispatch('copyLink', 'google.com');
        $this->alert('success', 'Tautan berhasil disalin!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            // 'text' => 'Link berhasil disalin.',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $surveyID = $this->surveyID;
        $targetRespondens = TargetResponden::whereIn('role_id', json_decode(Survey::find($surveyID)->role_id))->paginate(20);
        $targetRespondens = DB::table('target_respondens')
            ->leftJoin('entries', function ($join) {
                $join->on('target_respondens.id', '=', 'entries.target_responden_id')
                    ->where('entries.survey_id', '=', $this->surveyID);
            })
            // ->where('target_respondens.type', '=', 'individual')
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
            'expectedRespondents' => $this->expectedRespondents,
            'survey' => Survey::find($surveyID),
        ]);
    }
}