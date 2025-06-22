<?php

namespace App\Livewire\Department;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Artisan;

class UpdateDepartment extends Component
{
    /**
     * Define public property $department
     */
    public $department;

    #[Validate]
    public $name = '';
    #[Validate]
    public $status = '';

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:departments,name,' . $this->department->id,
            'status' => 'required',
        ];
    }

    /**
     * Define public function mount()
     * @return void
     */
    public function mount(): void
    {
        $this->name = $this->department->name;
        $this->status = $this->department->status;
    }
    /**
     * Define public method update()
     * @return void
     */
    public function update()
    {
        $this->validate();
        $this->department->update([
            "name" => $this->name,
            "slug" => Str::slug($this->name),
            "status" => $this->status,
        ]);
        Artisan::call('optimize:clear');
        flash()->success('Department Updated!');
        return redirect()->to('/dashboard/department');
    }

    /**
     * Define method for render the view page
     * @return Factory|View
     */
    public function render(): Factory|View
    {
        return view('livewire.department.update-department');
    }
}