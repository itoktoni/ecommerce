<?php

namespace Plugin;

use App\Dao\Models\Filters;
use DB;
use Curl;
use File;
use Route;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Thedevsaddam\LaravelSchema\Schema\Schema as Table;
use Illuminate\Support\Str;

class Helper
{
    public static function base_url()
    {
        return config('app.url');
    }
    public static function access()
    {
        $split = explode('/', Route::current()->uri);
        $access = $split[0];
        return $access;
    }
    public static function secure()
    {
        return config('website.secure');
    }

    public static function asset($path)
    {
        $public = config('website.public');
        if (config('website.asset')) {
            $public = '';
        }
        return asset($public . $path, self::secure());
    }

    public static function disableSecure($path)
    {
        $public = config('website.public');
        if (config('website.env') == 'dev') {
            $public = '';
        }
        $path = asset($public . '/backend/' . config('website.backend') . '/' . $path, false);
        return $path;
    }

    public static function frontend($path)
    {
        return self::asset('/frontend/' . config('website.frontend') . '/' . $path);
    }

    public static function backend($path)
    {
        return self::asset('/backend/' . config('website.backend') . '/' . $path);
    }

    public static function credential($path)
    {
        return self::asset('/credential/' . $path);
    }

    public static function files($path)
    {
        return self::asset('/files/' . $path);
    }

    public static function vendor($path)
    {
        return self::asset('/vendor/' . $path);
    }

    public static function unic($length)
    {
        $chars = array_merge(range('a', 'z'), range('A', 'Z'));
        $length = intval($length) > 0 ? intval($length) : 16;
        $max = count($chars) - 1;
        $str = "";

        while ($length--) {
            shuffle($chars);
            $rand = mt_rand(0, $max);
            $str .= $chars[$rand];
        }

        return $str;
    }

    public static function autoNumber($tablename, $fieldid, $prefix, $codelength)
    {
        $db = DB::table($tablename);
        $db->select(DB::raw('max(' . $fieldid . ') as maxcode'));
        $db->where($fieldid, "like", "$prefix%");

        $ambil = $db->first();
        $data = $ambil->maxcode;

        if ($db->count() > 0) {
            $code = substr($data, strlen($prefix));
            $countcode = ($code) + 1;
        } else {
            $countcode = 1;
        }
        $newcode = $prefix . str_pad($countcode, $codelength - strlen($prefix), "0", STR_PAD_LEFT);
        return $newcode;
    }

    public static function getClass($class)
    {
        return (new \ReflectionClass($class))->getShortName();
    }

    public static function filterInput($value)
    {
        $number = str_replace('.', ',', str_replace(',', '', $value));
        if (is_numeric($number)) {
            return floatval($number);
        } else {
            return $value;
        }
    }

    public static function formatNumber($value)
    {
        return floatval(preg_replace("/[^0-9.]/", '', $value));
    }

    public static function label($data)
    {
        $controller = Route::current()->getController();
        $table = $controller->model->getTable();
        $datatable = $controller->model->datatable;
        $field = $controller->model->getFillable();
        // $list = [];
        // foreach ($field as $value) {

        //     $split = explode('_', $value);
        //     if (count($split) > 1) {
        //         $nama = ucwords(str_replace('_', ' ', $value));
        //     } else {
        //         $nama = ucwords($value);
        //     }

        //     $clean    = str_replace('Id', 'Code', $nama);
        //     $list[$value] = [false => $clean];
        // }

        // if (!empty($datatable)) {
        //     $field = array_merge($field, $datatable);
        // }

        if (array_key_exists($data, $datatable)) {
            return key(array_flip($datatable[$data]));
        }

        return ucwords(str_replace('_', ' ', $data));
    }

    public static function listData($datatable)
    {
        $collection = collect($datatable);
        $filtered = $collection->filter(function ($value, $key) {
            if (array_key_exists('1', $value)) {
                return $value[1];
            }
        });

        $collection = collect($filtered->all());
        $list_data = $collection->mapWithKeys(function ($value, $key) {
            return [$key => $value[1]];
        });

        return $list_data;
    }

    public static function masterCheckbox($template = null)
    {
        if (!empty($template)) {
            return 'page.' . $template . '.checkbox';
        }
        return 'page.master.checkbox';
    }

    public static function masterAction($template = null)
    {
        if (!empty($template)) {
            return 'page.' . $template . '.action';
        }
        return 'page.master.action';
    }

    public static function createImage($image)
    {
        return '<img src="' . self::files($image) . '">';
    }

    public static function createCheckbox($id)
    {
        return '<input type="checkbox" name="id[]" value="' . $id . '">';
    }

    public static function shareStatus($data)
    {
        $status = collect($data)->map(function ($item, $key) {
            if (is_array($item)) {
                return $item[0];
            }
            return $item;
        });
        return $status;
    }

    public static function createStatus($data, $status = false)
    {

        $color = 'default';
        $label = 'Unknows';

        if ($status) {
            $value = $data;
            if ($status[$value]) {
                if (is_array($status[$value]) && !empty($status[$value][1])) {

                    $label = $status[$value][0];
                    $color = $status[$value][1];
                } else {
                    $label = $status[$value];
                    $color = 'default';
                }
            }
        } else {

            $value = $data['value'];
            if (isset($data['status'][$value])) {
                if (is_array($data['status'][$value]) && !empty($data['status'][$value][1])) {
                    $label = $data['status'][$value][0];
                    $color = $data['status'][$value][1];
                } else {
                    $label = $data['status'][$value];
                    $color = 'default';
                }
            }
        }
        return '<span class="btn btn-xs btn-block btn-' . $color . '">' . $label . '</span>';
    }

    public static function createTag($data, $implode = false)
    {
        $string = '';
        if (!empty($data)) {
            $collection = collect(json_decode($data))->map(function ($value) {
                return str_replace('_', ' ', $value);
            });
            $string = $collection->implode(', ');
            if ($implode) {
                $string = $collection->implode($implode, ', ');
            }
        }
        return $string;
    }

    public static function createNumber($data, $active = true)
    {
        $status = $active ? 'success' : 'danger';
        $class = '<span class="text-' . $status . '">' . number_format($data) . '</span>';
        return $class;
    }

    public static function createSort($data)
    {
        $class = "form-control input-sm text-center";
        $aksi = '<input type="hidden" name="kode[]" value="' . $data['hidden'] . '">';
        $aksi = $aksi . '<input type="text" name="order[]" style="width:50px;" class="' . $class . '" value="' . $data['value'] . '">';
        return $aksi;
    }

    public static function createAction($data)
    {
        $action = '<div class="action text-center">';
        $id     = $data['key'];
        $button = 0;
        foreach ($data['action'] as $key => $value) {
            $val    = isset($value[1]) ? $value[1] : $key;
            if (array_key_exists($key, config('action'))) {
                $button++;
                $route  = route($data['route'] . '_' . $key, ['code' => $id]);
                $action = $action . '<a id="linkMenu" href="' . $route . '" class="btn btn-xs btn-' . $value[0] . '">' . $val . '</a> ';
            }
        }
        session()->put('button', $button);
        return $action . '</div>';
    }

    public static function getNameTable($table)
    {
        if (strpos($table, '_') !== false) {
            $explode = explode('_', $table);
            $first = $explode[0];
            $table = str_replace($first, '', $table);
        }
        return ucwords(str_replace('_', ' ', $table));
    }

    public static function createOption($option, $placeholder = true, $raw = false, $cache = false)
    {
        $data = [];
        if ($cache) {
            if (is_object($option) && Cache::has($option->getTable() . '_api')) {
                $parse = Cache::get($option->getTable() . '_api');
                if (empty($parse)) {
                    return $data;
                }
                return $parse;
            } else if (Cache::has($option)) {
                return Cache::get($option);
            }
        }
        try {
            if (is_object($option)) {
                $data = $option->dataRepository()->get();
                if (!$raw) {
                    $data = $data->pluck($option->searching, $option->getKeyName());
                }
                if ($placeholder) {
                    $data = $data->prepend('- Select ' . self::getNameTable($option->getTable()) . ' -', '');
                }
            } else {
                $response = Curl::to(route($option))->withData([
                    'clean' => true,
                    'api_token' => auth()->user()->api_token,
                ])->post();
                $json  = json_decode($response);
                if (isset($json->data)) {
                    $data = collect($json->data);
                }
            }
        } catch (Exception $e) {
            return $data;
        }
        if ($cache) {
            if (is_object($option)) {
                Cache::put($option->getTable() . '_api', $data, config('website.cache'));
            }
            Cache::put($option, $data, config('website.cache'));
        }

        return $data;
    }

    public static function getTable($table = null)
    {
        if (Cache::has('tables')) {
            $arrayTable = Cache::get('tables');
            if (empty($table)) {
                return $arrayTable;
            }
            return $arrayTable[$table];
        }

        return \Schema::getColumnListing($table);
    }

    public static function getTranslate($table, $merge = null)
    {
        $column = self::getTable($table);
        // dd($column);
        $data = [];
        foreach ($column as $key => $value) {
            $split = explode('_', $value);
            if (count($split) > 1) {
                $nama = ucwords(str_replace('_', ' ', $value));
            } else {
                $nama = ucwords($value);
            }

            $clean_id = str_replace('Id', '', $nama);
            $clean_table = str_replace(ucwords($table), '', $clean_id);
            if (ctype_space($clean_table)) {
                $clean_table = 'Code';
            }
            $data[$value] = [false => $clean_table];
        }

        if (!empty($merge)) {
            $data = array_merge($data, $merge);
        }
        return $data;
    }

    public static function fields($data)
    {
        $fields = self::listData($data);
        return $fields->keys()->all();
    }

    public static function checkJson($id, $data)
    {
        $status = false;
        if (!empty($data)) {
            $arr = json_decode($data);
            if (is_array($data) && in_array($id, $arr)) {
                $status = true;
            } elseif ($id == $arr) {
                $status = true;
            }
        }

        return $status;
    }

    public static function extension($data)
    {
        return File::extension($data);
    }

    public static function ext($data)
    {
        $icon = self::extension($data);
        $mapping = collect(config('icon'));
        $check = $mapping->has($icon);
        return $check ? config('icon.' . $icon) : 'file';
    }

    public static function mode($data)
    {
        $icon = self::extension($data);
        $mapping = collect(config('ext'));
        $check = $mapping->has($icon);
        return $check ? config('ext.' . $icon) : 'txt';
    }

    public static function getMethod($class, $module = false)
    {
        if ($module) {
            $className = 'Modules\\' . $module . '\\Http\\Controllers\\' . ucfirst(Str::camel($class . '_controller'));
        } else {
            $className = 'App\\Http\\Controllers\\' . ucfirst(Str::camel($class . '_controller'));
        }
        $reflector   = new \ReflectionClass($className);
        $methodNames = array();
        foreach ($reflector->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->class == $reflector->getName() && $method->name != '__construct' && $method->name != 'index') {
                $methodNames[] = $method->name;
            }
        }

        return $methodNames;
    }

    public static function dataColumn($datatable, $key)
    {
        return array_unique(array_merge(array_keys(($datatable)), [$key]));
    }

    public static function getDataFilter()
    {
        if (Cache::has('filter')) {
            $filter = Cache::get('filter');
        } else {
            $filter = DB::table((new Filters())->getTable())->get();
            Cache::put('filter', $filter, 3000);
        }
        if (!empty($filter)) {
            $data = $filter->where('module', request()->route()->getName())->all();
            if (!empty($data)) {
                return $data;
            }
        }

        return false;
    }

    public static function filter($data)
    {
        $dataFilter = self::getDataFilter();
        if ($dataFilter) {
            $data->where(function ($query) use ($dataFilter) {
                foreach ($dataFilter as $filtering) {
                    switch ($filtering->custom) {
                        case 1:
                            $value = json_decode($filtering->value);
                            break;
                        case 0:
                            $value = Auth()->user()->{$filtering->value};
                            break;
                    }
                    if ($filtering->operator) {
                        $query->{$filtering->function}($filtering->field, $filtering->operator, $value);
                    } else {
                        $query->{$filtering->function}($filtering->field, $value);
                    }
                }
            });
        }
        return $data;
    }

    public static function form($template, $folder = false)
    {
        $folder = config('action')['create'] ?? false;
        if ($folder) {
            return Str::snake($folder) . '_' . $template . '.form';
        }

        return 'page.' . $template . '.form';
    }

    public static function include($template, $folder = false)
    {
        $folder = config('action')['create'] ?? false;
        if ($folder) {
            return ucfirst($folder) . '::page.' . $template . '.form';
        }

        return 'page.' . $template . '.form';
    }

    public static function setExtendBackend($additional = false)
    {
        $path = 'backend.' . config('website.backend') . '.';
        return $additional ? $path . '.' . $additional : $path . 'app';
    }

    public static function setExtendFrontend($additional = false, $page = false)
    {
        $path = 'frontend.' . config('website.frontend') . '.';
        if ($additional && $page) {
            $path = $path . 'page.' . $additional;
        } else if ($additional && !$page) {
            $path =  $path . $additional;
        } else {
            $path =  $path . 'layouts';
        }
        return $path;
    }

    public static function setViewDashboard($template = 'default')
    {
        return 'page.home.' . $template;
    }

    public static function setViewEmail($template, $module = false)
    {
        if ($module) {
            return ucfirst($module) . '::email.' . $template;
        }

        return 'email.' . $template;
    }

    public static function setViewSpa($template, $module = false)
    {
        if ($module) {
            return ucfirst($module) . '::spa.' . $template;
        }

        return 'email.' . $template;
    }


    public static function setViewPrint($template, $module = false)
    {
        if ($module) {
            return ucfirst($module) . '::print.' . $template;
        }

        return 'print.' . $template;
    }

    public static function setViewSave($template = 'master', $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.save';
            return $view;
        }

        return 'page.' . $template . '.save';
    }

    public static function setViewForm($template = 'master', $form,  $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.' . $form;
            return $view;
        }

        return 'page.' . $template . '.' . $form;
    }

    public static function setViewCreate($template = 'master', $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.create';
            return $view;
        }

        return 'page.' . $template . '.create';
    }

    public static function setViewUpdate($template = 'master', $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.update';
            return $view;
        }

        return 'page.' . $template . '.update';
    }

    public static function setViewData($template = 'master', $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.data';
            return $view;
        }
        return 'page.' . $template . '.data';
    }

    public static function setViewShow($template = 'master', $modular = false)
    {
        if ($modular) {
            $view = ucfirst($modular) . '::page.' . $template . '.show';
            return $view;
        }

        return 'page.' . $template . '.show';
    }

    public static function setViewFrontend($template = 'default')
    {
        return 'frontend.' . config('website.frontend') . '.page.' . $template;
    }

    public static function getTemplate($class)
    {
        $controller = (new \ReflectionClass($class))->getShortName();
        $remove = Str::replaceLast('Controller', '', $controller);
        $clean = Str::replaceLast('Repository', '', $remove);
        return Str::snake($clean);
    }

    public static function uploadFile($file, $folder)
    {
        $name = false;
        if (!empty($file)) { //handle images
            $name   = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs($folder, $name);
            $file->storeAs($folder, 'thumbnail_' . $name);
            return $name;
        }
    }

    public static function uploadImage($file, $folder, $width = 400, $height = 150)
    {
        $name = false;
        if (!empty($file)) { //handle images
            $name   = time() . "." . $file->getClientOriginalExtension();
            $file->storeAs($folder, $name);
            $file->storeAs($folder, 'thumbnail_' . $name);
            //Resize image here
            $thumbnailpath = public_path('files//' . $folder . '//' . 'thumbnail_' . $name);
            $img = Image::make($thumbnailpath)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            return $name;
        }
    }

    public static function removeImage($name, $folder)
    {
        $status = false;
        $path = public_path('files//' . $folder . '//');
        if (file_exists($path . $name)) {
            unlink($path . $name);
            unlink($path . 'thumbnail_' . $name);
            $status = true;
        }
        return $status;
    }

    public static function snake($value)
    {
        return Str::snake($value);
    }
}