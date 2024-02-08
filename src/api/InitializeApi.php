<?php

/**  
 *  
 *  
 *  
 * @class   orange_money_cashin  
 * @author Bernard baudouin um
 * @link     
 * @version 1.0.2 
 */

namespace Boorwin\OrangeMoney\api;

use Boorwin\OrangeMoney\settings;


class InitializeApi
{

    // initiate the payment 
    public function InitiatePayment()
    {   
        $conf = new settings\Config();
        $token_url = $conf->get_mode_sandbox()? 'http://apiw.orange.cm/token' : 'https://apiw.orange.cm/token';
        $token = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded');
        curl_setopt($ch, CURLOPT_HEADER, 'Authorization: ' . $conf->get_auth_basic());
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $conf->get_api_key() . ":" . $conf->get_api_secret());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $auth_response = json_decode(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != 200) {
            // get the current domaaine name
            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $CurPageURL = $protocol . $_SERVER['HTTP_HOST'];
            // save the error file
            $auth_resp = json_encode($auth_response);
            $dir            =   'error/';
            $fileName       =    "error-" . time() . "-data.json";
            $saveFilePath   =   $dir . $fileName;
            $fp             =   fopen($saveFilePath, 'wb');
            $contents['flerror_path'] = "error/" . $fileName;
            fwrite($fp, $auth_resp);
            fclose($fp);
            echo $CurPageURL . '/' . $contents['flerror_path'];
            throw new \RuntimeException('Error unable to get a Access token please check your credentials and try again Or contact the developper !');
        }
        $token["TOKEN"] = $auth_response->access_token;
        $token["TYPE"] = $auth_response->token_type;
        $token["EXPIRATON"] = $auth_response->expires_in;

        return $token;
    }
    public function iniTes()
    {
        $data = $this->InitiatePayment();
        echo 'ACCESS TOKEN : ' . $data['TOKEN'];
    }
}
 $chec = new InitializeApi();
 $data = $chec-> iniTes();
