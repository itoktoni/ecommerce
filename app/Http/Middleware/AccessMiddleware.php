<?php

namespace App\Http\Middleware;

use App\Dao\Repositories\GroupModuleRepository;
use Closure;
use Plugin\Helper;
use App\Dao\Models\Action;
use App\Dao\Models\GroupModuleConnectionModule;
use App\Dao\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Dao\Models\ModuleConnectionAction;
use Illuminate\Support\Str;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public static $groupUser;
    public static $username;
    public static $action;
    public static $module;
    public static $module_connection_action;
    public static $group_module_connection_module;
    public static $group_module;
    public static $list_group_module;

    public function __construct(Action $action, Module $module, ModuleConnectionAction $module_connection_action, GroupModuleConnectionModule $group_module_connection_module, GroupModuleRepository $group_module)
    {
        self::$action = $action;
        self::$module = $module;
        self::$group_module = $group_module;
        self::$module_connection_action = $module_connection_action;
        self::$group_module_connection_module = $group_module_connection_module;

        if (self::$username == null) {
            self::$username  = Auth::user()->username ?? null;
            self::$groupUser = Auth::user()->group_user ?? null;
        }

        if (self::$list_group_module == null) {
            if (Cache::has(self::$username . '_group_list')) {
                self::$list_group_module = Cache::get(self::$username . '_group_list');
            } else {
                $group_list = $group_module->getGroupByUser(self::$groupUser)->get();
                self::$list_group_module = $group_list;
                Cache::rememberForever(self::$username . '_group_list', function () use ($group_list) {
                    return $group_list;
                });
            }
        }
    }

    public function handle($request, Closure $next)
    {
        $access = $this->gate($this->data());
        if (!$access) {
            abort(403);
        }
        $route = request()->route() ?? false;
        $module          = request()->segment(2) ?? false;
        $action_code     = $route->getName() ?? false;
        $action_function = $route->getActionMethod() ?? false;
        $arrayController = explode('@', $route->getAction()['controller']);
        $template        = Helper::getTemplate($arrayController[0]);
        $group           = session(self::$username . '_group_access') ?? false;
        // dump($access->where('action_code', $action_code));
        if (!$group) {
            $group = $access->where('action_code', $action_code)->first()->conn_gm_group_module ?? self::$list_group_module->first()->conn_gu_group_module;
            session()->put(self::$username . '_group_access', $group);
        }

        $action_list = $access->where('conn_gm_group_module', $group)->unique('action_code');
        $menu_list = $action_list->unique('module_code');
        // dd($action_list);
        $action      = $action_list->where('module_code', $module)->pluck('module_folder', 'action_function');
        $folder =  $action->first() ?? false;
        if(!$folder){
            session()->put(self::$username . '_group_access', $group);
        }
        view()->share([
            'module'          => $module,
            'action'          => $action,
            'action_code'     => $action_code,
            'action_list'     => $action_list,
            'action_function' => $action_function,
            'group_list'      => self::$list_group_module,
            'menu_list'       => $menu_list,
            'folder'          => $folder,
            'form'            => Str::snake($folder) . '_' . $template . '_',
            'template'        => $template,
            'template_action' => 'page.master.action',
        ]);
        config()->set('module', $module);
        config()->set('action', $action->toArray());
        return $next($request);
    }

    public function data()
    {
        if (Cache::has(self::$username . '_access_menu')) {
            return Cache::get(self::$username . '_access_menu');
        }

        return Cache::rememberForever(self::$username . '_access_menu', function () {
            $routing = DB::table(self::$action->getTable())
                ->leftJoin(self::$module_connection_action->getTable(), 'action_code', '=', 'conn_ma_action')
                ->leftJoin(self::$module->getTable(), 'conn_ma_module', '=', 'module_code')
                ->leftJoin(self::$group_module_connection_module->getTable(), 'conn_gm_module', '=', 'module_code')
                ->where('module_enable', '1')
                ->whereIn('conn_gm_group_module', self::$list_group_module->pluck('group_module_code')->toArray())
                ->orderBy('action_path', 'asc')
                ->orderBy('action_function', 'asc')
                ->orderBy('module_sort', 'asc')
                ->orderBy('action_sort', 'asc');
            return $routing->get();
        });
    }

    public function gate($access)
    {
        $white_list = [
            'home', 'dashboard', 'console', 'configuration', 'route', 'file', 'livewire', 'user'
        ];
        $segment = request()->segment(1) ?? '';
        $policy = $access->contains('action_code', Route::currentRouteName());
        if (!$policy && Route::currentRouteName() && !in_array($segment, $white_list)) {
            return false;
        }
        return $access;
    }
}
