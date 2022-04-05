<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('custom_asset')) {
    /**
     * Generate an asset path for the application.
     *
     */
    function custom_asset(string $path)
    {
        if (config('app.use_https', false)) {
            return app('url')->asset($path, null);
        } else {
            return app('url')->asset($path, true);
        }
    }
}

if(!function_exists('checkGuard')){
    function checkGuard(){
        foreach(array_keys(config('auth.guards')) as $guard){
            if(auth()->guard($guard)->check()) return $guard;
        }
        return null;
    }
}

if(!function_exists("get_image")){
    function get_image($image)
    {
        if(isset($image)){
            var_dump(1);die();
            return asset($image);
        }else{
            var_dump(1);die();
            return asset("admins/img/default-image.jpg");
        }

    }
};


if(!function_exists("check_room_current")){
    function check_room_current($weekday_id, $room_id, $array)
    {
        foreach ($array as $value) {
            if($value['weekday_id'] == $weekday_id && $value['room_id'] == $room_id) {
                return true;
            }
        }
        return false;
    }
};

if(!function_exists("check_shift_current")){
    function check_shift_current($weekday_id, $shift_id, $array)
    {
        foreach ($array as $item) {
            if($item['weekday_id'] == $weekday_id && $item['shift_id'] == $shift_id) {
                return true;
            }
        }
        return false;
    }
};

if(!function_exists("check_weekday_current")){
    function check_weekday_current($weekday_id, $array, $status)
    {
        foreach ($array as $item) {
            if($item['weekday_id'] == $weekday_id && $status == 'start_at') {
                return $item['shift']['start_at'];
            }

            if($item['weekday_id'] == $weekday_id && $status == 'end_at') {
                return $item['shift']['end_at'];
            }
        }
        return false;
    }
};

if(!function_exists("check_shift_same")){
    function check_shift_same($weekday_id, $shift_id, $array)
    {
        foreach ($array as $item) {
            if($item['weekday_id'] == $weekday_id && in_array($shift_id, $item['shift_ids'])) {
                return true;
            }
        }
        return false;
    }
};
