<?php

namespace App\Livewire\AdminUser;

use App\Livewire\Forms\AdminUserCreateRequest;
use App\Mail\UserMail;
use App\Models\Department;
use App\Services\AdminUser\AdminUserService;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Component {
    /**
     * Define public form method AdminUserCreateRequest $form;
     */
    public AdminUserCreateRequest $form;

    /**
     * Define public property $roles
     * @var array|object
     */
    public array | object $roles;
    /**
     * Define public property $roles
     * @var array|object
     */
    public array | object $departments;

    /**
     * Define public method save() to store the resources
     * @param AdminUserService $service
     * @return void
     */
    public function save(AdminUserService $service): void {
        $this->form->validate();
        $isCreate = $service->store($this->form);
        if (!empty($isCreate)) {
            Mail::to($isCreate->email)->queue(new UserMail($isCreate));
        }
        $response = $isCreate ? 'Data has been submit successfully !' : 'Something went wrong !';
        flash()->success($response);
        $this->form->reset();
    }

    public function render() {
        $this->roles       = Role::query()->whereNotIn('id', [1])->get();
        $this->departments = Department::query()->get();
        return view('livewire.adminuser.create-adminuser');
    }
}
