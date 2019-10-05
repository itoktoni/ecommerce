<?php

namespace Plugin;

class Alert
{
    private const create = 'Created';
    private const update = 'Succeed';
    private const delete = 'Deleted';
    private const failed = 'Failed';
    private const error = 'Error';
    private const success = 'success';
    private const warning = 'warning';
    private const danger = 'danger';
    private const primary = 'primary';

    public static function create($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::create . ' !');
    }

    public static function update($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::update . ' !');
    }

    public static function delete($data = null)
    {
        session()->put(self::success, $data ?? 'Data has been ' . self::delete . ' !');
    }

    public static function error($data = null)
    {
        session()->put(self::danger, config('website') == 'production' ? 'Data got error !' : $data . ' !');
    }
}
