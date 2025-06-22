<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Define public method store to save the resources
     * @param $form
     * @return array|object
     */
    public function store(array | object $request): array | object
    {
        $response = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);

        return $response;
    }

    /**
     * Define public method update to update the resources
     * @param Model $model
     * @param $request
     * @return array|object|bool
     */
    public function update(Model $model, $request): array | object | bool
    {
        $model->update($request->all());
        return $model;
    }
}
