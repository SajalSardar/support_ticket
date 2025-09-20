<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class AdminUserCreateRequest extends Form {
    /**
     * Define public property $name
     * @var string
     */
    #[Validate('required|min:2|max:20', as : 'Name')]
    public ?string $name = '';

    /**
     * Define public property $email
     * @var ?string
     */
    #[Validate('required|email|max:30|unique:users', as : 'Email')]
    public ?string $email;

    /**
     * Define public property $email
     * @var ?string
     */
    #[Validate('required|int', as : 'Department')]
    public ?string $department_id;

    /**
     * Define public property $password
     * @var ?string
     */
    #[Validate('required|min:8', as : 'Password')]
    public ?string $password;

    /**
     * Define public property $role_id
     * @var ?string
     */
    #[Validate('required|int', as : 'Role')]
    public $role_id;
}
