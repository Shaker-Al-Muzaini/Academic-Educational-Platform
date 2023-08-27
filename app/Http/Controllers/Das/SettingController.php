<?php

namespace App\Http\Controllers\Das;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
class SettingController extends Controller
{
    public  function  index (){
        $settings = Setting::pluck('value', 'key')->toArray();

        if (! $settings) {
            return config('settings.default');
        }

        return $settings;
    }

    public  function  update()
    {
        $settings = request()->validate(Setting::rules());

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }

        Cache::flush('settings');

        return response()->json(['success' => true]);

    }
}
