<?php
namespace App\Http\Controllers;

use App\Libs\ShopifyCurl;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ThemesController extends BaseController
{
    private $shopify;

    public function __construct(ShopifyCurl $shopify)
    {
        $this->shopify=$shopify;
    }

    public function getThemesList(){

        $result = $this->shopify->send('GET',"/admin/themes.json");
        print_r($result);
    }

    public function getThemesFile($id){
        $result = $this->shopify->send('GET',"/admin/themes/".$id."/assets.json");
        print_r($result);

    }


}