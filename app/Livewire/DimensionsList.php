<?php

namespace App\Livewire;

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
    public $search = '';

    public function rules()
    {
        return [
            'name' => [
                'required',
                // 'min:5',
                Rule::unique('dimensions')
            ],
        ];
    }

    public function create()
    {
        $this->validate();
        Dimension::create($this->all());
        $this->reset('name');
        session()->flash('success', 'Dimension sukses ditambahkan.');
    }

    public function delete($dimensionID)
    {
        $dimensi = Dimension::find($dimensionID);
        if ($dimensi->questions()->count() > 0) {
            session()->flash('errorHapus', 'Dimensi tidak dapat dihapus karena memiliki pertanyaan.');
        } else {
            $dimensi->delete();
            session()->flash('successHapus', 'Dimensi berhasil dihapus.');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $dimensions = Dimension::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);
        if ($dimensions->isNotEmpty()) {
            return view('livewire.dimensions-list', [
                'dimensions' => $dimensions
            ]);
        } else {
            session()->flash('gagalSearch', 'Dimensi tidak dapat ditemukan');
            return view('livewire.dimensions-list', [
                'dimensions' => $dimensions
            ]);
        }
    }
}
