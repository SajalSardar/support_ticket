<?php

namespace App\Livewire\Team;

use App\Enums\Bucket;
use App\LocaleStorage\Fileupload;
use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdateTeam extends Component {
    use WithFileUploads;

    public $team;
    public $agentUser;
    public $categories;
    public $departments;

    #[Validate]
    public $name;

    #[Validate]
    public $status;

    #[Validate]
    public $categories_input = [];

    #[Validate]
    public $image;

    #[Validate]
    public $agent_id = [];

    #[Validate]
    public $department_id;

    protected function rules() {
        return [
            'name'             => 'required|min:3|unique:categories,name,' . $this->team->id,
            'status'           => 'required',
            'categories_input' => 'required',
            'department_id'    => 'required',
            'agent_id'         => 'nullable',
            'image'            => 'nullable|mimes:jpg,jpeg,png|max:3024',
        ];
    }
    public function mount(): void {
        // dd($this->team->department->id);
        $this->name             = $this->team->name;
        $this->status           = $this->team->status;
        $this->categories_input = $this->team->teamCategories->pluck('id')->toArray();
        $this->agent_id         = $this->team->agents->pluck('id')->toArray();
        $this->department_id    = $this->team->department->id ?? null;
    }
    public function update() {
        Gate::authorize('update', Team::class);
        $this->validate();
        $this->team->update([
            'name'          => $this->name,
            'slug'          => Str::slug($this->name),
            'status'        => $this->status,
            'department_id' => $this->department_id,
        ]);

        $this->team->teamCategories()->sync($this->categories_input);
        $this->team->agents()->sync($this->agent_id);
        $isUpload = $this->image ? Fileupload::update($this->form, Bucket::TEAM, $this->team, $this->team->getKey(), Team::class, 300, 300) : '';

        flash()->success('Data has been update successfuly');
        return redirect()->to('/dashboard/team');
    }
    public function render() {
        Gate::authorize('update', Team::class);
        return view('livewire.team.update-team');
    }
}
