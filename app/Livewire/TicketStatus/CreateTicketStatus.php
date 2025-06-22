<?php

namespace App\Livewire\TicketStatus;

use App\Models\TicketStatus;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTicketStatus extends Component {

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:ticket_statuses,name',
            'status' => 'required',
        ];
    }

    public function save() {
        Gate::authorize('create', TicketStatus::class);
        $this->validate();

        TicketStatus::create([
            "name"   => $this->name,
            "slug"   => Str::slug($this->name),
            "status" => $this->status,
        ]);

        flash()->success('Status Created!');
        return redirect()->to('/dashboard/request-status');
    }

    public function render() {
        Gate::authorize('create', TicketStatus::class);
        return view('livewire.ticketstatus.create-ticketstatus');
    }
}