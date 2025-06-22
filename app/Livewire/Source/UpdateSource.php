<?php

namespace App\Livewire\Source;

use App\Models\Source;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateSource extends Component {

    public $source;

    #[Validate]
    public $title = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'title'  => 'required|unique:sources,title,' . $this->source->id,
            'status' => 'required',
        ];
    }

    /**
     * Define public function mount()
     */
    public function mount(): void {
        $this->title  = $this->source->title;
        $this->status = $this->source->status;
    }

    public function update() {
        Gate::authorize('update', Source::class);

        $this->validate();

        $this->source->update([
            "title"  => $this->title,
            "status" => $this->status,
        ]);

        flash()->success('Source updated!');
        return redirect()->to('/dashboard/source');
    }

    public function render() {
        Gate::authorize('update', Source::class);
        return view('livewire.source.update-source');
    }
}