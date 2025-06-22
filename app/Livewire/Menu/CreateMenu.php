<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateMenu extends Component {

    public $roles;
    public $routes;
    public $parent_menus = null;
    public $permission_list;

    #[Validate]
    public $name = '';
    public $parent_id = null;
    #[Validate]
    public $route = '';
    public $url = null;
    public $icon = '';
    public $role = [];
    public $permission = [];
    #[Validate]
    public $status = 'active';
    #[Validate]
    public $order = null;

    protected function rules() {
        return [
            'name'   => 'required|min:3|unique:menus,name',
            'route'  => 'required',
            'status' => 'required',
            'order'  => 'nullable|integer',
        ];
    }

    public function saveMenu() {
        $this->validate();
        array_push($this->role, 'super-admin');
        $rolesArray = array_unique($this->role);
        Menu::create([
            "name"        => $this->name,
            "slug"        => Str::slug($this->name),
            "user_id"     => Auth::id(),
            "parent_id"   => $this->parent_id ?? null,
            "route"       => $this->route,
            "url"         => $this->url,
            "icon"        => $this->icon,
            "roles"       => json_encode($rolesArray),
            "permissions" => json_encode($this->permission),
            "status"      => $this->status,
            "order"       => $this->order,
        ]);
        if ($this->parent_id) {
            $parentMenu = Menu::where('id', $this->parent_id)->first();
            $role       = json_decode($parentMenu->roles, true);
            $newRoles   = array_unique(array_merge($role, $this->role), SORT_REGULAR);
            $parentMenu->update([
                'roles' => json_encode($newRoles),
            ]);
        }
        flash()->success('Menu Created!');
        return redirect()->to('/dashboard/menu');
    }

    public function render() {
        return view('livewire.menu.create-menu');
    }
}
