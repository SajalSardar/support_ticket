<?php

namespace App\Livewire\Category;

use App\Enums\Bucket;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use App\LocaleStorage\Fileupload;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
use App\Services\Category\CategoryService;
use App\Livewire\Forms\CategoryUpdateRequest;

class UpdateCategory extends Component
{
    use WithFileUploads;
    /**
     * Define public property $parent_categories;
     * @var array|object
     */
    public array|object $parent_categories;

    /**
     * Define public property $category;
     * @var array|object
     */
    public array|object $category;

    /**
     * Define public form object CategoryCreateRequest $form
     */
    public CategoryUpdateRequest $form;

    /**
     * Define public method mount()
     * @return void
     */
    public function mount()
    {
        $this->form->ignore = $this->category->id;
        $this->form->name = $this->category?->name;
        $this->form->status = $this->category?->status;
        $this->form->parent_id = $this->category?->parent_id;
    }

    /**
     * Define public method update()
     * @return void
     */
    public function update(CategoryService $service)
    {
        Gate::authorize('update', Category::class);
        $this->validate(rules: $this->form->rules());
        $isCreate = $service->update($this->category, $this->form);
        $isUpload = $isCreate ? Fileupload::update($this->form, Bucket::CATEGORY, $this->category, $isCreate->getKey(), Category::class, 300, 300) : false;
        $response = ($isUpload || $isCreate) ? 'Data has been update successfuly' : 'Something went wrong';
        flash()->success($response);
        Artisan::call('optimize:clear');
        $this->form->reset();
    }

    public function render()
    {
        Gate::authorize('update', Category::class);

        return view('livewire.category.update-category');
    }
}
