<?php

namespace App\Exports\Sheets;

use App\Models\Answer;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataSheet implements FromArray, WithHeadings, WithTitle
{
    private $surveyID;
    public $dataArray = [];
    public $headingArray = [];
    public $headingCodeArray = [];
    public $batchNumber;

    public function __construct(int $surveyID, $batchNumber)
    {
        $this->surveyID = $surveyID;
        $this->batchNumber = $batchNumber;
    }

    public function getDataArray()
    {
        ini_set('memory_limit', '1G');
        set_time_limit(60);
        // Tentukan ukuran batch
        $batchSize = 250;

        // Tentukan posisi batch
        $batchNumber = $this->batchNumber;

        // Hitung offset berdasarkan posisi batch
        $offset = ($batchNumber - 1) * $batchSize;

        // Ambil entri berdasarkan offset dan ukuran batch
        $entries = Survey::find($this->surveyID)->entries()->skip($offset)->take($batchSize)->get();

        $array = [];

        foreach ($entries as $entry) {
            $answers = $entry->answers;
            $answerEntry = [];
            foreach ($answers as $answer) {
                if ($answer->questionType->name == 'Harapan' || $answer->questionType->name == 'Kenyataan') {
                    $answerValue = $answer->value;
                    $answerKalimat = $answer->getAnswerValueAttribute($answerValue);
                } else {
                    $answerKalimat = $answer->value;
                }
                $answerEntry[] = $answerKalimat;
            }
            $array[] = $answerEntry;
        }

        $this->dataArray = $array;
    }



    public function array(): array
    {
        $this->getDataArray();
        return $this->dataArray;
    }

    public function getHeadingCodeArray()
    {
        $array = [];
        $survey = Survey::find($this->surveyID);
        $questions = $survey->questions;
        foreach ($questions as $key => $question) {
            // start untuk rumus kode pertanyaan
            $questionSectionID = $question->section->id;
            // mengganti questionID dengan key saja
            $questionID = $key + 1;
            $questionTypeID = $question->questionType->id;
            if ($questionTypeID == 1) {
                $questionTypeID = 'U';
            } else if ($questionTypeID == 2) {
                $questionTypeID = 'H';
            } else {
                $questionTypeID = 'K';
            }
            $row = 'B' . $questionSectionID . 'P' . $questionID  . $questionTypeID;
            // end untuk rumus kode pertanyaan
            $array[] = $row;
        }
        $this->headingCodeArray = $array;
        // dd($array);
    }

    public function getHeadingArray()
    {
        $array = [];
        $survey = Survey::find($this->surveyID);
        $questions = $survey->questions;
        foreach ($questions as $question) {
            $pertanyaan = $question->content;
            $kodeQuestionType = $question->questionType->name;
            $array[] = $question->content . ' (' . $kodeQuestionType . ')';
        }
        $this->headingArray = $array;
    }

    public function headings(): array
    {
        $this->getHeadingArray();
        $this->getHeadingCodeArray();
        return [
            $this->headingArray,
            $this->headingCodeArray,
        ];
    }

    public function title(): string
    {
        return 'Data';
    }
}
