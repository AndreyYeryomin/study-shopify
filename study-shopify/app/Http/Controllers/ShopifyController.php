<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ShopifyController extends BaseController
{
    public $api_key;
    public $secret_key;
    public $redirect_url;
    function __construct()
    {
        $this->api_key = env('API_KEY');
        $this->secret_key = env('SECRET_KEY');
        $this->redirect_url = env('REDIRECT_URL');


    }
    public function checkUrl(Request $request)
    {
        if(count($request->query()) > 0 ){
            if($request->query('hmac')){
                $hamc = $request->query('hmac');
                $shop = $request->query('shop');
                $timestamp = $request->query('timestamp');
                $this->requestVerify($hamc,$shop,$timestamp);
            }else{

                return "hello world";
            }

        }else{
            return "hello world";
        }


    }
    public function requestVerify($hmac,$shop,$timestamp){

        $message = "shop=".$shop."&timestamp=".$timestamp;

        if(hash_hmac('sha256', $message, $this->secret_key) == $hmac){
            $scope = 'write_orders,read_customers';
            header("Location: https://{$shop}/admin/oauth/authorize?client_id={$this->api_key}&amp;scope={$scope}&amp;redirect_uri={$this->redirect_url}");
                die();
        }else{
            return 'hello world';
        }

    }
    public function oAuth(Request $request){
        if(count($request->query()) > 0 ){
            $code = $request->query('code');
            $hmac = $request->query('hmac');
            $shop = $request->query('shop');
            $timestamp = $request->query('timestamp');
            $message = "code=".$code."&shop=".$shop."&timestamp=".$timestamp;

            if ((hash_hmac('sha256', $message, $this->secret_key) == $hmac)){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://{$shop}/admin/oauth/access_token",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST"
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                 return var_dump($response);
            }else{
                return 'hello world';
            }
        }else{
            return "hello world";
        }
    }
}
