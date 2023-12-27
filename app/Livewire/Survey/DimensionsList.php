<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\Dimension;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class DimensionsList extends Component
{
    use WithPagination;
    #[Validate]
    public $name = '';
    #[Validate]
    public $description = '';
    public $search = '';

    public $editingDimensionID;
    public $editingDimensionDescription;

    public function rules()
    {
        return [
            'name' => [
                'required',
                // 'min:5',
                Rule::unique('dimensions')
            ],
            'description' => [
                'required',
                'min:5',
            ],
        ];
    }

    public function create()
    {
        $this->validate();
        Dimension::create($this->all());
        $this->reset('name', 'description');
        session()->flash('success', 'Dimensi sukses ditambahkan.');
    }

    public function delete($dimensionID)
    {
        $dimensi = Dimension::find($dimensionID);
        if ($dimensi->questions()->count() > 0) {
            session()->flash('errorHapus', 'Dimensi tidak dapat dihapus karena telah digunakan di pertanyaan.');
        } else {
            $dimensi->delete();
            session()->flash('successHapus', 'Dimensi berhasil dihapus.');
        }
    }

    public function edit($dimensionID)
    {
        $this->editingDimensionID = $dimensionID;
        $dimensi = Dimension::find($dimensionID);
        $this->editingDimensionDescription = $dimensi->description;
    }

    public function cancelEdit()
    {
        $this->reset('editingDimensionID', 'editingDimensionDescription');
    }
    public function update($dimensionID)
    {
        $this->validate([
            'editingDimensionDescription' => 'required|min:5'
        ]);

        Dimension::find($dimensionID)->update([
            'description' => $this->editingDimensionDescription
        ]);
        $this->cancelEdit();
        session()->flash('successUpdate', [
            'message' => 'Deskripsi Dimensi berhasil diubah.',
            'dimensionID' => $dimensionID
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // $dimensions = Dimension::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);
        $dimensions = Dimension::withCount('questions')
            ->where('name', 'like', "%{$this->search}%")
            ->orderByDesc('questions_count')
            ->latest()
            ->paginate(5);
        if ($dimensions->isNotEmpty()) {
            return view('livewire.survey.dimensions-list', [
                'dimensions' => $dimensions
            ]);
        } else {
            session()->flash('gagalSearch', 'Dimensi tidak dapat ditemukan');
            return view('livewire.survey.dimensions-list', [
                'dimensions' => $dimensions
            ]);
        }
    }
}
