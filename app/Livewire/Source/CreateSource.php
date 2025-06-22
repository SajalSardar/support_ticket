<?php

namespace App\Livewire\Source;

use App\Models\Source;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateSource extends Component {
    #[Validate]
    public $title = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'title'  => 'required|unique:sources,title',
            'status' => 'required',
        ];
    }

    public function save() {
        Gate::authorize('create', Source::class);

        $this->validate();

        Source::create([
            "title"  => $this->title,
            "status" => $this->status,
        ]);

        flash()->success('source Created!');
        return redirect()->to('/dashboard/source');
    }

    public function render() {
        Gate::authorize('create', Source::class);

        return view('livewire.source.create-source');
    }
}