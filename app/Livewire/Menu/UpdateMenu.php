<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateMenu extends Component {
    /**
     * Define public property $roles
     * @var array|object
     */
    public $roles;
    public $routes;
    public $permission_list;

    /**
     * Define public property $menu
     */
    public $menu;

    public $parent_menus = null;
    #[Validate]
    public $name = '';
    public $parent_id = null;
    #[Validate]
    public $route = '';
    public $url = null;
    public $icon = '';
    public $role;
    public $permission;
    #[Validate]
    public $status = '';
    #[Validate]
    public $order = null;

    protected function rules() {
        return [
            'name'   => 'required|min:3|unique:menus,name,' . $this->menu->id,
            'route'  => 'required',
            'status' => 'required',
            'order'  => 'nullable|integer',
        ];
    }

    /**
     * Define public function mount()
     */
    public function mount(): void {
        $this->name       = $this->menu->name;
        $this->parent_id  = $this->menu->parent_id;
        $this->route      = $this->menu->route;
        $this->url        = $this->menu->url;
        $this->icon       = $this->menu->icon;
        $this->role       = json_decode($this->menu->roles, true);
        $this->status     = $this->menu->status;
        $this->order      = $this->menu->order;
        $this->permission = json_decode($this->menu->permissions, true);
    }
    /**
     * Define public method update()
     * @return void
     */
    public function update() {

        $this->validate();
        if ($this->role) {
            array_push($this->role, 'super-admin');
            $rolesArray = array_unique($this->role);
        }
        $this->menu->update([
            "name"        => $this->name,
            "slug"        => Str::slug($this->name),
            "user_id"     => Auth::id(),
            "parent_id"   => $this->parent_id ?? null,
            "route"       => $this->route,
            "url"         => $this->url,
            "icon"        => $this->icon,
            "roles"       => !empty($rolesArray) ? json_encode($rolesArray) : $this->menu->roles,
            "permissions" => json_encode($this->permission),
            "status"      => $this->status,
            "order"       => $this->order,
        ]);
        if ($this->parent_id && $this->role) {
            $parentMenu = Menu::where('id', $this->parent_id)->first();
            $role       = json_decode($parentMenu->roles, true);
            $newRoles   = array_unique(array_merge($role, $this->role), SORT_REGULAR);
            $parentMenu->update([
                'roles' => json_encode($newRoles),
            ]);
        }
        flash()->success('Menu Updated!');
        return back();
    }

    public function render() {
        return view('livewire.menu.update-menu');
    }
}
