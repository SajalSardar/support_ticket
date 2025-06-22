<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class CategoryUpdateRequest extends Form
{
    /**
     * Define public property $ignore
     */
    public $ignore;

    /**
     * Define public property $name
     * @var ?string
     */
    public ?string $name;

    /**
     * Define public property $parent_id
     * @var ?string
     */
    public $parent_id;

    /**
     * Define public property $image
     */
    public $image;

    /**
     * Define public property $status
     * @var ?string
     */
    public $status;

    /**
     * Define public method rules()
     * @return array
     */
    public function rules()
    {
        $arr['form.name']      = ['required', 'max:30', Rule::unique(Category::class, 'name')->ignore($this->ignore)];
        $arr['form.parent_id'] = ['nullable'];
        $arr['form.image']     = ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:3024'];
        $arr['form.status']    = ['required', 'int'];

        return $arr;
    }
}
