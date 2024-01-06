<?php

namespace App\Livewire\Survey;

use Livewire\Component;
use App\Models\Dimension;
use App\Models\Subdimension;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class DimensionsList extends Component
{
    use WithPagination;
    use LivewireAlert;

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
        // $this->validate();
        $this->validate([
            'name' => 'required|min:5|unique:dimensions',
            'description' => 'required|min:5'
        ]);
        // Dimension::create($this->all());
        Dimension::create([
            'name' => $this->name,
            'description' => $this->description
        ]);
        $this->reset('name', 'description');
        // session()->flash('success', 'Dimensi sukses ditambahkan.');
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Dimensi sukses ditambahkan.',
        ]);
    }

    public function delete($dimensionID)
    {
        $dimensi = Dimension::find($dimensionID);
        if ($dimensi->questions()->count() > 0) {
            session()->flash('errorHapus', 'Dimensi tidak dapat dihapus karena telah digunakan di pertanyaan.');
            $this->alert('error', 'Gagal!', [
                'position' => 'center',
                'timer' => 4000,
                'toast' => true,
                'text' => 'Dimensi tidak dapat dihapus karena telah digunakan di pertanyaan.',
            ]);
        } else {
            $dimensi->delete();
            // session()->flash('successHapus', 'Dimensi berhasil dihapus.');
            $this->alert('success', 'Sukses!', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => 'Dimensi Berhasil Dihapus',
            ]);
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
        // session()->flash('successUpdate', [
        //     'message' => 'Deskripsi Dimensi berhasil diubah.',
        //     'dimensionID' => $dimensionID
        // ]);
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Dimensi sukses diupdate.',
        ]);
    }

    // FOR SUBDIMENSION
    #[Validate('required|not_in:')]
    public $dimensionID;
    #[Validate('required|min:5')]
    public $subdimensionName = '';
    #[Validate('required|min:5')]
    public $subdimensionDescription = '';

    public function createSubdimension()
    {
        $this->validate([
            'dimensionID' => 'required|not_in:',
            'subdimensionName' => 'required|min:5',
            'subdimensionDescription' => 'required|min:5'
        ]);

        Subdimension::create([
            'name' => $this->subdimensionName,
            'description' => $this->subdimensionDescription,
            'dimension_id' => $this->dimensionID
        ]);
        $this->reset('subdimensionName', 'subdimensionDescription', 'dimensionID');
        // session()->flash('success', 'Subdimensi sukses ditambahkan.');
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => true,
            'text' => 'Subdimensi sukses ditambahkan.',
        ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // $dimensions = Dimension::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);
        // $dimensions = Dimension::withCount('questions')
        //     ->where('name', 'like', "%{$this->search}%")
        //     ->orderByDesc('questions_count')
        //     ->latest()
        //     ->paginate(5);
        $dimensions = Dimension::latest()
            ->where('name', 'like', "%{$this->search}%")
            // ->orderByDesc('questions_count')
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
