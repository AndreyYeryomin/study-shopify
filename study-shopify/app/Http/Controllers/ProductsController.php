<?php
namespace App\Http\Controllers;

use App\Libs\ShopifyCurl;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Slince;

class ProductsController extends ShopifyController
{

    /**
     * @var ShopifyCurl
     */
    private $shopify;
    public $curl;
    public $shop;
    public $token;

    public function __construct( ShopifyCurl $shopify ){
        $this->shopify = $shopify;
        $this->curl = $this->shopify->init();
        $this->shopify->setStoreDomain('test-andrey-study.myshopify.com');
        $this->shop = $this->shopify->getStoreDomain();
        $token =DB::table('shopify')->where('name_shop','=',$this->shop)->value('access_token');
        $this->shopify->setTokenAccess($token);
        $this->token = $this->shopify->getTokenAccess();

    }

    public function getProductsList(){
        $result = $this->shopify->send('GET',"/admin/products.json");
        print_r($result);
    }

    public function getProductInfo($id){
        $result = $this->shopify->send('GET',"/admin/products/{$id}.json");
        print_r($result);
    }
    public function deleteProduct($id){

        $this->shopify->send('DELETE',"/admin/products/{$id}.json");
    }
    public function postProduct(){
        $data =  (object) [
            'title' => 'asdasd'
        ];
        $data_string = json_encode(array('product' => $data));
        $this->shopify->send('POST',"/admin/products.json", $data_string);
    }
    public function productUpdate($id){
        $data =  (object) [
            'id' => $id,
            'title' => 'asdasd'
        ];
        $data_string = json_encode(array('product' => $data));
        $this->shopify->send('PUT',"/admin/products/{$id}.json", $data_string);
    }
    public function getProductCollection(){
        $result = $this->shopify->send('GET',"admin/collects.json");
        print_r($result);
    }

}