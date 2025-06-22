<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * Define public function locale to change language
     * @param $lang
     */
    public function locale($lang)
    {
        if (in_array($lang, ['en', 'bn'])) {
            App::setLocale($lang);
            Session::put('locale', $lang);
        }
        return back();
    }
}
