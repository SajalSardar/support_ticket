<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class CategoryCreateRequest extends Form
{
    /**
     * Define public property $name
     * @var ?string
     */
    #[Validate('required|max:30|unique:categories', as: 'Name')]
    public ?string $name;

    /**
     * Define public property $parent_id
     * @var ?string
     */
    #[Validate('nullable|int', as: 'Parent Category')]
    public $parent_id;

    /**
     * Define public property $image
     */
    #[Validate('nullable|image|mimes:jpg,png,jpeg|max:3024', as: 'Image')]
    public $image;

    /**
     * Define public property $status
     * @var ?string
     */
    #[Validate('required|int', as: 'Status')]
    public $status;
}
