<?php

namespace App\Livewire;

use App\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class CreateModule extends Component {

    #[Validate('required|min:2', as :'Name')]
    public $name = '';
    public $folder_name = '';
    public $permission;
    public $view;
    public $livewire_component;
    public $mcrp;

    public function save() {

        $this->validate();

        $replace_name       = str_replace(" ", '', trim($this->name));
        $name               = Str::ucfirst($replace_name);
        $name_lower         = Str::lower($replace_name);
        $name_lower_orginal = Str::lower($this->name);

        $moduleOldData = Module::where('slug', $name_lower)->first();

        if (empty($moduleOldData)) {
            $moduleOldData = [
                'permission'         => null,
                'view'               => null,
                'livewire_component' => null,
                'mcrp'               => null,
            ];
        }

        $moduleData = Module::updateOrCreate(
            [
                'name' => $name,
            ],
            [
                'slug'               => Str::slug($name),
                "permission"         => $this->permission ?? @$moduleOldData->permission,
                "view"               => $this->view ?? @$moduleOldData->view,
                "livewire_component" => $this->livewire_component ?? @$moduleOldData->livewire_component,
                "mcrp"               => $this->mcrp ?? @$moduleOldData->mcrp,
            ]
        );
        flash()->success('Module created!');

        //create permission
        if ($this->permission) {
            $permissionData = Permission::where('module_id', $moduleData->id)->get();
            if ($permissionData->isEmpty()) {
                $arrayOfPermissionNames = [
                    $name_lower_orginal . ' view list',
                    $name_lower_orginal . ' create',
                    $name_lower_orginal . ' update',
                    $name_lower_orginal . ' delete',
                    $name_lower_orginal . ' restore',
                    $name_lower_orginal . ' force delete',
                ];

                $permissions = collect($arrayOfPermissionNames)->map(function ($permission) use ($moduleData) {
                    return [
                        'name'       => $permission,
                        'module_id'  => $moduleData->id,
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });

                Permission::insert($permissions->toArray());
                flash()->success('Permission create successfull!');
            }
        }

        //Livewire component
        if ($this->livewire_component && $moduleOldData['livewire_component'] == null) {
            $createFileName = 'Livewire/' . $name . '/Create' . $name . '.php';
            $updateFileName = 'Livewire/' . $name . '/Update' . $name . '.php';

            $directory = app_path('Livewire/' . $name);

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            if (!File::exists(app_path($createFileName))) {
                $contents = "<?php

                namespace App\\Livewire\\$name;

                use Livewire\\Component;

                class Create$name extends Component
                {
                    public function render()
                    {
                        return view('livewire.$name_lower.create-$name_lower');
                    }
                }";
                File::put(app_path($createFileName), $contents);
            }

            if (!File::exists(app_path($updateFileName))) {
                $contents = "<?php

                namespace App\\Livewire\\$name;

                use Livewire\\Component;

                class Update$name extends Component
                {
                    public function render()
                    {
                        return view('livewire.$name_lower.update-$name_lower');
                    }
                }";
                File::put(app_path($updateFileName), $contents);
            }

            //view
            $createViewContent = <<<EOD
            <div class="border border-slate-300 p-5 rounded">
                <div class="flex justify-end pb-3 fixed top-24 right-10">
                    <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded" href="#">
                     $name List
                    </a>
                </div>
                <header class="flex justify-between mb-5">
                    <h4>$name Create</h4>
                </header>
                <form action="#">
                    <div class="flex justify-between">
                        <div class="p-2 w-full">
                            <x-forms.text-input type="text" placeholder="Enter Event Name" />
                        </div>

                        <div class="p-2 w-full">
                            <x-forms.text-input type="date" />
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="p-2 w-full">
                            <x-forms.text-input type="time" />
                        </div>

                        <div class="p-2 w-full">
                            <x-forms.text-input type="text" placeholder="Enter event address" />
                        </div>
                    </div>

                    <div class="p-2">
                        <x-buttons.primary>
                            Save $name
                        </x-buttons.primary>
                    </div>

                </form>
            </div>

EOD;
            $viewDirectory      = resource_path('views/livewire/' . $name_lower);
            $createViewFileName = resource_path('views/livewire/' . $name_lower . '/create-' . $name_lower . '.blade.php');
            $updateViewFileName = resource_path('views/livewire/' . $name_lower . '/update-' . $name_lower . '.blade.php');

            if (!File::exists($viewDirectory)) {
                File::makeDirectory($viewDirectory, 0755, true);
            }

            if (!File::exists($createViewFileName)) {
                File::put($createViewFileName, $createViewContent);
            }

            if (!File::exists($updateViewFileName)) {
                File::put($updateViewFileName, $createViewContent);
            }

            flash()->success('Livewire component created!');
        }

        // blade view
        if ($this->view && $moduleOldData['view'] == null) {
            $viewContent = <<<EOD
            <div class="flex justify-end pb-3 fixed top-24 right-10">
                <a type="submit" class="px-8 py-2 bg-primary-400 text-white rounded" href="#">
                Create $name
                </a>
            </div>
            <table class="w-full table-fixed">
                    <thead class="w-full bg-slate-100 mb-5">
                        <tr>
                            <th class="text-start ps-10 py-2">Published Events</th>
                            <th class="text-start ps-10 py-2">Sold</th>
                            <th class="text-start ps-10 py-2">Gross</th>
                            <th class="text-start ps-10 py-2">Status</th>
                            <th class="text-start ps-10 py-2">Action</th>
                        </tr>
                    </thead>

                    <tbody class="mt-5">
                        <tr class="rounded shadow">
                            <td class="p-10 flex">
                                <div class="profile">
                                    <img src="" alt="user_picture">
                                </div>
                                <div class="infos ps-5">
                                    <h5 class="font-medium text-slate-900">Business Innovation conf 24</h5>
                                    <p class="font-normal text-gray-400">11 Aug, 2024 - Sunday</p>
                                    <p class="font-normal text-gray-400">11.00-11.30 AM</p>
                                    <p class="font-normal text-gray-400">334,New York,USA</p>
                                </div>
                            </td>
                            <td class="p-10 font-normal text-gray-400">0/3</td>
                            <td class="p-10 font-normal text-gray-400">$50</td>
                            <td class="p-10 font-normal text-gray-400">Upcoming Event</td>
                            <td class="p-10 font-normal text-gray-400">
                                <div class="flex">
                                    <a href="" class="p-2">
                                        <img src="http://log_my_request.test:82/assets/icons/edit.png" alt="edit">
                                    </a>
                                    <form class="" action="" method="POST">
                                        <button type="submit" class="p-2">
                                            <img src="http://log_my_request.test:82/assets/icons/delete.png" alt="__delete">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
EOD;
            $bladeViewDirectory = resource_path('views/' . $name_lower);
            $createViewBlade    = resource_path('views/' . $name_lower . '/create.blade.php');
            $viewCreate         = "<x-app-layout><livewire:$name_lower.create-$name_lower /></x-app-layout>";
            $updateViewBlade    = resource_path('views/' . $name_lower . '/edit.blade.php');
            $viewUpdate         = "<x-app-layout><livewire:$name_lower.update-$name_lower /></x-app-layout>";
            $indexViewBlade     = resource_path('views/' . $name_lower . '/index.blade.php');
            $showViewBlade      = resource_path('views/' . $name_lower . '/show.blade.php');

            if (!File::exists($bladeViewDirectory)) {
                File::makeDirectory($bladeViewDirectory, 0755, true);
            }
            if (!File::exists($createViewBlade)) {
                File::put($createViewBlade, $viewCreate);
            }
            if (!File::exists($updateViewBlade)) {
                File::put($updateViewBlade, $viewUpdate);
            }
            if (!File::exists($indexViewBlade)) {
                File::put($indexViewBlade, "<x-app-layout>$viewContent</x-app-layout>");
            }
            if (!File::exists($showViewBlade)) {
                File::put($showViewBlade, "<x-app-layout>$viewContent</x-app-layout>");
            }
            flash()->success('view blade file created!');
        }

        //Create model,controller,migration,policy,resource route
        if (!file_exists(app_path('Models/' . $name . ".php")) && $this->mcrp && $moduleOldData['mcrp'] == null) {
            if (!empty($this->folder_name)) {

                $replace_folder_name = str_replace(" ", '_', trim($this->folder_name));
                $folder_name         = Str::ucfirst($replace_folder_name);

                Artisan::call("make:model " . $name . " -m --policy");
                Artisan::call("make:controller " . $folder_name . '/' . $name . "Controller --model=$name --resource");
            } else {
                Artisan::call("make:model " . $name . " -mcr --policy");
            }
            flash()->success('Create model,controller,migration,policy,resource route created!');
        }

        flash()->success('All Done!');
        return redirect()->to('/dashboard/module/create');
    }

    public function render() {
        return view('livewire.create-module');
    }
}
