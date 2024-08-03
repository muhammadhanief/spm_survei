<?php

namespace App\Exports;

use App\Exports\Sheets\DataSheet;
use App\Exports\Sheets\DictionarySheet;
use App\Models\Answer;
use App\Models\Survey;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnswersExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */

    protected $surveyID;
    public $dataArray = [];
    public $headingArray = [];
    public $batchNumber;

    public function __construct($surveyID, $batchNumber)
    {
        $this->surveyID = $surveyID;
        $this->batchNumber = $batchNumber;
    }

    public function sheets(): array
    {
        $sheets = [
            new DataSheet($this->surveyID, $this->batchNumber),
            new DictionarySheet($this->surveyID),
        ];
        return $sheets;
    }
}
