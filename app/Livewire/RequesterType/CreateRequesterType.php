<?php

namespace App\Livewire\RequesterType;

use App\Models\RequesterType;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateRequesterType extends Component {

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:requester_types,name',
            'status' => 'required',
        ];
    }

    public function save() {
        Gate::authorize('create', RequesterType::class);
        $this->validate();

        RequesterType::create([
            "name"   => $this->name,
            "status" => $this->status,
        ]);

        flash()->success('Type Created!');
        return redirect()->to('/dashboard/requestertype');
    }

    public function render() {
        Gate::authorize('create', RequesterType::class);
        return view('livewire.requestertype.create-requestertype');
    }
}