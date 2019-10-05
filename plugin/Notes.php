<?php

namespace Plugin;

class Notes
{
    private const create = 'Create';
    private const update = 'Update';
    private const delete = 'Delete';
    private const error = 'Error';

    public static function create($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::create;
        $log['data'] = $data;
        return $log;
    }

    public static function update($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::update;
        $log['data'] = $data;
        return $log;
    }

    public static function delete($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::delete;
        $log['data'] = $data;
        return $log;
    }

    public static function error($data = null)
    {
        $log['status'] = false;
        $log['form'] = self::error;
        $log['data'] = $data;
        return $log;
    }
}
