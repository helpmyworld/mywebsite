<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    /**
     * Return a fresh captcha image HTML via JSON.
     */
    public function reload()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
