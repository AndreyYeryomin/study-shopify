<?php
/**
 * Created by PhpStorm.
 * User: devit31
 * Date: 17.05.18
 * Time: 12:21
 */

namespace App\Http\Middleware;


use Illuminate\Http\Request;

class CheckValidation
{
    public function handle(Request $request)
    {
        $arr = $request->query();
        $hmac = $arr['hmac'];
        $shop = $arr['shop'];
        $api_key = env('API_KEY');
        $secret_key = env('SECRET_KEY');
        $redirect_url = env('REDIRECT_URL');
        unset( $arr['hmac']);
        $message = http_build_query($arr);
        $message = urldecode($message);
        if(hash_hmac('sha256', $message, $secret_key) == $hmac){
            if(count(DB::table('shopify')->get()->where('name_shop','=',$shop))>0){
                return view('index');
            }else {
                $scope = 'write_orders,read_customers,read_content,write_content,read_themes,write_themes,read_products, write_products,read_product_listings,read_customers, write_customers,read_orders, write_orders,read_draft_orders, write_draft_orders,read_inventory, write_inventory,read_locations,read_script_tags, write_script_tags,read_fulfillments, write_fulfillments,read_shipping, write_shipping,read_analytics';
                header("Location: https://{$shop}/admin/oauth/authorize?client_id={$api_key}&amp;scope={$scope}&amp;redirect_uri={$redirect_url}");
                die();
            }
        }else{
            header("Location: https://apps.shopify.com");
            die();
        }

        }



}