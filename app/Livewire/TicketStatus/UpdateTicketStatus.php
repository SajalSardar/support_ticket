<?php

namespace App\Livewire\TicketStatus;

use App\Models\TicketStatus;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateTicketStatus extends Component {
    public $ticketstatus;

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules() {
        return [
            'name'   => 'required|unique:ticket_statuses,name,' . $this->ticketstatus->id,
            'status' => 'required',
        ];
    }
    public function mount(): void {
        $this->name   = $this->ticketstatus->name;
        $this->status = $this->ticketstatus->status;
    }

    public function update() {
        Gate::authorize('update', TicketStatus::class);
        $this->validate();

        $this->ticketstatus->update([
            "name"   => $this->name,
            'slug'   => Str::slug($this->name),
            "status" => $this->status,
        ]);

        flash()->success('Status updated!');
        return redirect()->to('/dashboard/request-status');
    }
    public function render() {
        Gate::authorize('update', TicketStatus::class);
        return view('livewire.ticketstatus.update-ticketstatus');
    }
}