<?php

namespace App\Livewire\Option;

use Livewire\Component;
use App\Models\AnswerOption;
use App\Models\AnswerOptionValue;
use Livewire\WithPagination;

class SearchAnswerOption extends Component
{
    use WithPagination;

    protected $listeners = ['optionCreated' => 'refreshSearch'];
    public $search;
    // Utuk Modal Subdimensi
    public $showingAnswerOptionID = '';
    public $showingAnswerOptionName = '';

    public function showAnswerOptionValueModal($answerOptionID)
    {
        $this->showingAnswerOptionID = $answerOptionID;
        $answerOption = AnswerOption::find($answerOptionID);
        $this->showingAnswerOptionName = $answerOption->name;
    }

    public function refreshSearch()
    {
        $this->render();
    }

    public function render()
    {
        $answerOption = AnswerOption::where('name', 'like', '%' . $this->search . '%')->paginate(5);
        if ($answerOption->isNotEmpty()) {
            return view('livewire.option.search-answer-option', [
                'answerOptions' => $answerOption,
                'answerOptionValues' => AnswerOptionValue::all(),
            ]);
        } else {
            session()->flash('gagalSearch', 'Paket jawaban tidak dapat ditemukan');
            return view('livewire.option.search-answer-option', [
                'answerOptions' => $answerOption,
                'answerOptionValues' => AnswerOptionValue::all(),
            ]);
        }
    }
}
