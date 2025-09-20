<?php

namespace App\Livewire\Team;

use App\Enums\Bucket;
use App\Livewire\Forms\TeamCreateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use App\Services\Team\TeamService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateTeam extends Component {
    use WithFileUploads;

    /**
     * Define public form object TeamCreateRequest $form
     */
    public TeamCreateRequest $form;

    /**
     * Define public property $categories
     * @var array|object
     */
    public $categories;

    /**
     * Define public property $departments
     * @var array|object
     */
    public $departments;
    /**
     * Define public property $departments
     * @var array|object
     */
    public $employees;

    public $selectedDepartment = null;

    public function mount() {
        $this->departments = Department::where('status', 1)->get();
        $this->employees   = [];

    }

    public function updatedFormDepartmentId($departmentId) {
        $this->employees = User::role('employee')
            ->where('department_id', $departmentId)
            ->get();
    }

    /**
     * Define public method save() to store the resource
     */
    public function save(TeamService $service) {
        Gate::authorize('create', Team::class);
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->image ? Fileupload::upload($this->form, Bucket::TEAM, $isCreate->getKey(), Team::class, 300, 300) : '';
        $response = $isCreate ? 'Data has been update successfully' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('/dashboard/team');
    }

    public function render() {
        Gate::authorize('create', Team::class);
        return view('livewire.team.create-team');
    }
}
