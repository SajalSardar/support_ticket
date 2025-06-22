<?php

namespace App\Livewire\RequesterType;

use App\Models\RequesterType;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateRequesterType extends Component {
    public $requestertype;

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:requester_types,name,' . $this->requestertype->id,
            'status' => 'required',
        ];
    }

    public function mount(): void {
        $this->name   = $this->requestertype->name;
        $this->status = $this->requestertype->status;
    }

    public function update() {
        Gate::authorize('update', RequesterType::class);

        $this->validate();

        $this->requestertype->update([
            "name"   => $this->name,
            "status" => $this->status,
        ]);

        flash()->success('Update request type!');
        return redirect()->to('/dashboard/requestertype');
    }

    public function render() {
        Gate::authorize('update', RequesterType::class);
        return view('livewire.requestertype.update-requestertype');
    }
}