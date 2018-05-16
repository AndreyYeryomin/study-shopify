<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ProductsController extends ShopifyController
{

    public function getProductsList(){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $url_page = "https://{$shop}/admin/products.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        print_r($result);
    }

    public function getProductInfo($id){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $url_page = "https://{$shop}/admin/products/{$id}.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $token = json_decode ($result,true);
        print_r($token);
    }
    public function deleteProduct($id){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $url_page = "https://{$shop}/admin/products/{$id}.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $token = json_decode ($result,true);
        print_r($token);
    }
    public function postProduct(){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $data =  (object) [
            'title' => 'asdasd'
        ];
        $data_string = json_encode(array('product' => $data));
        var_dump($data_string);
        $url_page = "https://{$shop}/admin/products.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        $token = json_decode ($result,true);
        print_r($token);
    }
    public function productUpdate($id){
        $shop ='test-andrey-study.myshopify.com';
        $token =DB::table('shopify')->where('name_shop','=',$shop)->value('access_token');
        $data =  (object) [
            'id' => $id,
            'title' => 'asdasd'
        ];
        $data_string = json_encode(array('product' => $data));
        $url_page = "https://{$shop}/admin/products/{$id}.json?access_token={$token}";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_page);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        $token = json_decode ($result,true);
        print_r($token);
    }

}