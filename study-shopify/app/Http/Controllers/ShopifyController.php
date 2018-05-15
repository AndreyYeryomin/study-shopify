<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ShopifyController extends BaseController
{
    public function checkUrl(Request $request)
    {
        echo $request->query('hmac');

    }
}
