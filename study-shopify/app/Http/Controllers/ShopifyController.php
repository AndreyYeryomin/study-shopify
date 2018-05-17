<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ShopifyController extends BaseController
{
    public $api_key;
    public $secret_key;
    public $redirect_url;
    public $shop;
    function __construct()
    {
        $this->api_key = env('API_KEY');
        $this->secret_key = env('SECRET_KEY');
        $this->redirect_url = env('REDIRECT_URL');


    }
    public function checkUrl(Request $request)
    {
        if(count($request->query()) > 0 ){
            if($request->query('hmac') && $request->query('shop')){
                $arr = $request->query();
                    $hmac = $request->query('hmac');
                    $this->shop = $request->query('shop');
                    $timestamp = $request->query('timestamp');
                    unset( $arr['hmac']);
                    $message = http_build_query($arr);
                    $message = urldecode($message);
                    if(hash_hmac('sha256', $message, $this->secret_key) == $hmac) {
                        if(count(DB::table('shopify')->get()->where('name_shop','=',$this->shop))>0){
                            $jwt_token = $this->getJWT();
                           return view('index')->with('token',$jwt_token);
                        }else{
                            $scope = 'write_orders,read_customers,read_content,write_content,read_themes,write_themes,read_products, write_products,read_product_listings,read_customers, write_customers,read_orders, write_orders,read_draft_orders, write_draft_orders,read_inventory, write_inventory,read_locations,read_script_tags, write_script_tags,read_fulfillments, write_fulfillments,read_shipping, write_shipping,read_analytics';
                            header("Location: https://{$this->shop}/admin/oauth/authorize?client_id={$this->api_key}&amp;scope={$scope}&amp;redirect_uri={$this->redirect_url}");
                            die();
                        }

                    }else{
                        header("Location: https://apps.shopify.com");
                        die();
                    }

            }

        }else{
            header("Location: https://apps.shopify.com");
            die();
        }

    }
/*    public function requestVerify($hmac,$message,$shop){

        if(hash_hmac('sha256', $message, $this->secret_key) == $hmac){
            $scope = 'write_orders,read_customers,read_content,write_content,read_themes,write_themes,read_products, write_products,read_product_listings,read_customers, write_customers,read_orders, write_orders,read_draft_orders, write_draft_orders,read_inventory, write_inventory,read_locations,read_script_tags, write_script_tags,read_fulfillments, write_fulfillments,read_shipping, write_shipping,read_analytics';
            header("Location: https://{$shop}/admin/oauth/authorize?client_id={$this->api_key}&amp;scope={$scope}&amp;redirect_uri={$this->redirect_url}");
            die();
        }else{
            header("Location: https://apps.shopify.com");
            die();
        }

    }*/
    public function install(Request $request){
            $hmac = $request->query('hmac');
            $code =$request->query('code');
            $shop =$request->query('shop');
            $timestamp = $request->query('timestamp');
            if(count(DB::table('shopify')->get()->where('name_shop','=',$shop))>0){
                header("Location: https://{$shop}/admin/apps/{$this->api_key}");
                die();
            }else {
                $message = "code=" . $code . "&shop=" . $shop . "&timestamp=" . $timestamp;

                if ((hash_hmac('sha256', $message, $this->secret_key) == $hmac)) {
                    $url_page = "https://{$shop}/admin/oauth/access_token";
                    $param = "client_id=" . $this->api_key . "&client_secret=" . $this->secret_key . "&code=" . $code;
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url_page);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($curl);
                    $token = json_decode($result, true);
                    $access_token = $token['access_token'];
                    $users = DB::table('shopify')->get()->where('access_token', '=', $access_token);
                    if (count($users) > 0) {
                    } else {
                        DB::table('shopify')->insert(['access_token' => $access_token, 'name_shop' => $shop]);
                    }
                    return view('index');
                } else {
                    header("Location: https://apps.shopify.com");
                    die();
                }
            }

    }

    public function getJWT(){
        $token =DB::table('shopify')->where('name_shop','=',$this->shop)->value('access_token');
        $header =  (object) [
            "alg"=>"HS256",
            "typ"=>"JWT"
        ];
        $header = json_encode($header);
        $payload= (object)[
            "access_token"=>$token
        ];
        $payload = json_encode($payload);
        $unsigned_token = base64_encode($header) . base64_encode($payload);
        $signature = hash_hmac('sha256', $unsigned_token, $this->secret_key);
        $jwt = base64_encode($header).base64_encode($payload).base64_encode($signature);
        return $jwt;
    }
}
