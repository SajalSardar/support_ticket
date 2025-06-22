<?php

namespace App\Services\AdminUser;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserService
{
    /**
     * Define public method store to save the resource
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        $user = User::factory()->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $roleName = Role::query()->where('id', $request->role_id)->first();
        return $user->assignRole($roleName);
    }

    /**
     * Define public method update to update the resource
     * @param Model $model
     * @param $request
     * @return array|object
     */
    public function update(Model $model, $request): array | object
    {
        $model->update($request->all());
        $roleName = Role::query()->where('id', $request->role_id)->first();
        $response = $model->syncRoles($roleName);

        return $response;
    }
}
