<?php

namespace App\Livewire\Category;

use App\Enums\Bucket;
use App\Livewire\Forms\CategoryCreateRequest;
use App\LocaleStorage\Fileupload;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use WithFileUploads;

    /**
     * Define public property $parent_categories;
     * @var array|object
     */
    public array | object $parent_categories;

    /**
     * Define public form object CategoryCreateRequest $form
     */
    public CategoryCreateRequest $form;

    /**
     * Define public method save() to save the resources
     * @param CategoryService $service
     */
    public function save(CategoryService $service)
    {
        Gate::authorize('create', Category::class);
        $this->form->validate();
        $isCreate = $service->store($this->form);
        $isUpload = $this->form->image ? Fileupload::upload($this->form, Bucket::CATEGORY, $isCreate->getKey(), Category::class, 300, 300) : '';
        $response = $isCreate ? 'Data has been update successfully' : 'Something went wrong';
        flash()->success($response);
        return redirect()->to('/dashboard/category');
    }

    public function render()
    {
        Gate::authorize('create', Category::class);
        return view('livewire.category.create-category');
    }
}
