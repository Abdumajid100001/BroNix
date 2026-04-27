<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
public function update($locale)
{
if (!in_array($locale, ['ru', 'en', 'tj'])) {
abort(404);
}

Session::put('locale', $locale);
App::setLocale($locale);

return redirect()->back();
}
}
