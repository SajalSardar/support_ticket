<?php

namespace App\Livewire\AdminUser;

use App\Livewire\Forms\AdminUserUpdateRequest;
use App\Services\AdminUser\AdminUserService;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UpdateAdminUser extends Component {
    /**
     * Define publlic property $roles
     * @var array|object
     */
    public array | object $roles;

    /**
     * Define public property $user;
     */
    public array | object $user;

    /**
     * Define public form method AdminUserUpdateRequest $form;
     */
    public AdminUserUpdateRequest $form;

    /**
     * Define public method mount()
     * @return void
     */
    public function mount(): void {
        $this->form->ignore  = $this->user->id;
        $this->form->name    = $this->user?->name;
        $this->form->email   = $this->user?->email;
        $this->form->role_id = $this->user->roles->first()->id;
    }

    /**
     * Define public method update() to update the resourses
     * @return void
     */
    public function update(AdminUserService $service): void {
        $this->validate(rules: $this->form->rules(), attributes: $this->form->attributes());
        $isUpdate = $service->update($this->user, $this->form);
        $response = $isUpdate ? 'Data has been update sccessfully !' : 'Something went wrong !';
        flash()->success($response);
    }

    public function render() {
        $this->roles = Role::query()->whereNotIn('id', [1])->get();
        return view('livewire.adminuser.update-adminuser');
    }
}
