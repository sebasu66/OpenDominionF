<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Validate that the locale exists in your supported locales
        // For example, you might have a config array of supported locales
        $supportedLocales = ['en', 'es']; // Add more as needed

        if (! in_array($locale, $supportedLocales)) {
            $locale = config('app.fallback_locale'); // Fallback to default
        }

        app()->setLocale($locale);
        Session::put('locale', $locale);

        return redirect()->back();
    }
}
