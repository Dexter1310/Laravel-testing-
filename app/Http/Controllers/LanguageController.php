<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


class LanguageController extends Controller
{
    public function select(Request $request)
    {
        $lang = $request->get('locale');

            session()->put('locale', $lang);

        return redirect()->back();
    }
}
