<?php

namespace App\Providers;

use App\Models\Sys\Menu;
use App\Models\Sys\Module;
use App\Models\Sys\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AdminLteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    //
    }

    protected function parseMenu($menus, $parent = null)
    {
        $result = [];
        $order = [];
        foreach ($menus as $index => $menu) {
            if ($menu['parent_id'] == $parent) {
                unset($menus[$index]);
                $order[] = $menu['order'];
                $submenu = $this->parseMenu($menus, $menu['id']);
                if (count($submenu)) {
                    $menu['submenu'] = $submenu;
                }
                unset($menu['id']);
                $result[] = $menu;
            }
        }
        if ($result != []) {
            array_multisort($order, $result);
        }

        return $result;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $menus = DB::table(Menu::getTableName(), 'm')
                ->join(Module::getTableName('mo'), 'mo.id', '=', 'm.module_id')
                ->leftJoin(Route::getTableName('r'), 'r.id', '=', 'm.route_id')
                ->where([
                    ['mo.url', request()->route()->getPrefix()],
                    ['m.is_active', true]
                ])->where('m.role_id', auth()->user()->current_role_id)
                ->select([
                    'm.id', 'm.parent_id', 'm.text', 'r.url',
                    'r.active', 'm.icon', 'r.can', 'm.order', 'm.parent_id',
                ])->orderBy('order')
                ->get()->map(function($data) {
                    return [
                      'data' => ['menu-id' => $data->id],
                      'active' => explode(',', $data->active),
                    ] + (array) $data;
                });
            if (!empty($menus)) {
                $menus = $this->parseMenu($menus);
                // $this->normalizeMenu($menus);
                $event->menu->add(...$menus);
            }
        });
    //
    }
}
