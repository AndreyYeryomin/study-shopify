<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class BlogsController extends BaseController
{

    public function getBlogsList(){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $url_page = "https://{$shop}/admin/blogs.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        print_r($result);
    }

}