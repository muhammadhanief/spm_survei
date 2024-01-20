<?php

namespace App\Livewire\TargetResponden;

use Livewire\Component;
use App\Models\TargetResponden;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TargetRespondenPage extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';

    public function delete($id)
    {
        $targetResponden = TargetResponden::find($id);
        $targetResponden->delete();
        // session()->flash('success', 'Target Responden berhasil dihapus.');
        $this->alert('success', 'Sukses!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => 'Database Responden Berhasil Dihapus',
        ]);
    }




    #[Layout('layouts.app')]
    public function render()
    {
        $targetRespondens = TargetResponden::where('name', 'like', "%{$this->search}%")
            ->orderByDesc('role_id')
            ->paginate(5);

        if ($targetRespondens->isNotEmpty()) {
            return view('livewire.target-responden.target-responden-page', [
                'targetRespondens' => $targetRespondens,
            ]);
        } else {
            session()->flash('gagalSearch', 'Dimensi tidak dapat ditemukan');
            return view('livewire.target-responden.target-responden-page', [
                'targetRespondens' => $targetRespondens,
            ]);
        }
    }
}
