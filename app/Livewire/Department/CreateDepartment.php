<?php

namespace App\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Artisan;

class CreateDepartment extends Component
{

    #[Validate]
    public $name = '';
    public $status = true;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|unique:departments,name',
            'status' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();
        Department::create([
            "name" => $this->name,
            "slug" => Str::slug($this->name),
            "status" => $this->status,
        ]);
        Artisan::call('optimize:clear');
        flash()->success('Department Created!');
        return redirect()->to('/dashboard/department');
    }

    public function render()
    {
        return view('livewire.department.create-department');
    }
}