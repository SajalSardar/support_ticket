<?php

use App\Models\Menu;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Helper {
    /**
     * Define public static method ISOdate() to see the date in international format
     * @param $date
     * @return string
     */
    public static function ISOdate($date) {
        return $date ? date('M d, Y', strtotime($date)) : '';
    }

    /**
     * Define public function for active and inactive status
     * @param string $status
     * @return string
     */
    public static function status(?string $status): string {
        if ($status == '1') {
            return '<span class="inline-flex px-3 py-1 border border-resolved-400 items-center text-sm font-inter ml-1 rounded text-resolved-400"> Active</span>';
        } else {
            return '<span class="inline-flex px-3 py-1 border border-closed-400 items-center text-sm font-inter ml-1 rounded text-closed-400"> Inactive </span>';
        }
    }

    /**
     * Define public static function badge(?string $string)
     * @param ?string $string
     * @return string
     */
    public static function badge(?string $string): string {
        $escapedString = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        return '<span class="inline-flex px-3 py-1 bg-inProgress-400/10 text-inProgress-400 items-center text-sm font-inter ml-1 rounded">
                <span class="p-1">
                ' . $escapedString . '
           </span></span>';
    }

    /**
     * Define public function for show date in human readable form
     * @param string $date
     * @return string
     */
    public static function humanReadableDate(?string $date): string {
        return Carbon::parse($date)->diffForHumans();
    }

    //get login user roles
    public static function getLoggedInUserRoles() {
        $user = auth()->user()->load('roles');
        return $user->roles;
    }
    public static function getLoggedInUserRoleSession() {
        $loginRole = Session::has('login_role') ? Session::get('login_role') : '';
        return $loginRole;
    }

    public static function roleWiseAccess($role) {
        if (auth()->user()->hasRole($role) && Helper::getLoggedInUserRoleSession() === $role) {
            return true;
        }
        return false;
    }

    //get all menu and sub menu
    // public static function getAllMenus() {
    //     $loginRole = Helper::getLoggedInUserRoleSession();
    //     $menus     = Menu::with(['submneus' => function ($q) use ($loginRole) {
    //         $q->orderBy('order', 'asc')
    //         // ->whereNotNull('permissions')
    //             ->where('status', 'active');
    //         // ->whereJsonContains('roles', $loginRole);
    //     }])
    //     // ->whereJsonContains('roles', $loginRole)
    //         ->where('parent_id', null)
    //         ->where('status', 'active')
    //         ->orderBy('order', 'asc')
    //         ->get();

    //     return $menus;
    // }
    public static function getAllMenus() {
        $menus = Menu::with([
            'submneus' => function ($q) {
                $q->orderBy('order', 'asc')
                    ->where('status', 'active');
            },
        ])
            ->where('parent_id', null)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();
        $user = User::where('id', Auth::id())->first();

        if (!$user->hasRole('super-admin')) {
            foreach ($menus as $key => $menu) {

                if (count($menu->submneus) > 0) {
                    foreach ($menu->submneus as $subKey => $subMenu) {

                        $subMenuPermission = $subMenu->permissions ? json_decode($subMenu->permissions, true) : [];

                        if (!$user->hasAnyPermission($subMenuPermission)) {
                            $menu->submneus->forget($subKey);
                        }
                    }
                }
                if (count($menu->submneus) == 0) {
                    $menuPermission = $menu->permissions ? json_decode($menu->permissions, true) : [];
                    if (!$user->hasAnyPermission($menuPermission)) {
                        $menus->forget($key);
                    }
                    if (($menu->route == "#" || $menu->route == null) && $menu->url == null) {
                        $menus->forget($key);
                    }
                }
            }
        }

        return $menus;
    }
}
