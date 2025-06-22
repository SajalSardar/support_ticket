<?php

namespace App\Services\Team;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TeamService
{
    /**
     * Define public method store to save the resource
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        $team = Team::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'status'        => $request->status,
            'department_id' => $request->department_id,
        ]);

        $teamCategories = [];

        $team->teamCategories()->attach($request->category_id);
        $team->agents()->attach($request->agent_id);
        return $team;
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
