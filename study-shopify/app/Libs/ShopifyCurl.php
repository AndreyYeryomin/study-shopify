<?php

namespace App\Libs;

/**
 * Created by PhpStorm.
 * User: devit31
 * Date: 18.05.18
 * Time: 17:33
 */

class ShopifyCurl
{

    public $curl;

    private $storeDomain;
    private $tokenAccess;


    public function init()
    {
        $this->curl=curl_init();
        return $this->curl;
    }

    public function setStoreDomain( $storeDomain ) {

        $this->storeDomain = $storeDomain;

    }

    public function getStoreDomain(){

        return $this->storeDomain;

    }

    public function getTokenAccess(){

        return $this->tokenAccess;

    }

    public function setTokenAccess($tokenAccess){

        $this->tokenAccess = $tokenAccess;

    }

    public function send($method,$url,$data=''){

        if($method == "POST" || $method == "PUT"){
          $url = $this->getRequestUrl($url);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
                    'X-Shopify-Access-Token:' .$this->tokenAccess,
                    'Content-Length: ' . strlen($data)
                     )
            );

            return curl_exec($this->curl);
        }else{

            $url = $this->getRequestUrl($url);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
                    'X-Shopify-Access-Token:' .$this->tokenAccess
                )
            );

            return curl_exec($this->curl);
        }
    }

    public function getRequestUrl($url){

        return "https://{$this->storeDomain}".$url;
    }

}