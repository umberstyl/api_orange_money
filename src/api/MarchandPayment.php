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

// Include the configuration file 

namespace Boorwin\OrangeMoney\api;


class MarchandPayment
{

    private $API_url;
    public function __construct()
    {
        $this->API_url  = ORANGE_MONEY_SANDBOX ? 'http://apiw.orange.cm/omcoreapis/1.0.2' : 'https://apiw.orange.cm/omcoreapis/1.0.2'; 

    }
    //  process the marchant payment 
    public function mpayment($args = [], $n_json = false)
    {
        $mTokens = $this->get_paytoken();
        $params = [
            "notifUrl" => $args['callback'],
            "channelUserMsisdn" => ORANGE_MONEY_CHANNEL_USER_MSISDN,
            "amount" => $args['amount'],
            "subscriberMsisdn" => $args['phone'],
            "pin" => ORANGE_MONEY_PIN,
            "orderId" => $args['order_id'],
            "description" => $args['desc'],
            "payToken" => $mTokens['payToken']
        ];
        $params =  json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_url . '/mp/pay');
        curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded'); 
        curl_setopt($ch, CURLOPT_HEADER, 'Authorization: Bearer ' .  $mTokens['TOKEN']);
        curl_setopt($ch, CURLOPT_HEADER, 'X-AUTH-TOKEN: ' . ORANGE_MONEY_XAUTH_TOKEN);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $payment = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $mpayment = json_decode($payment, true);
        if ($http_code != 200) {
             // get the current domaaine name
             $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
             $CurPageURL = $protocol . $_SERVER['HTTP_HOST'];
             // save the error file
             $dir            =   'error/';	
             $fileName	   =    "error-".time()."-data.json";
             $saveFilePath   =   $dir . $fileName;
             $fp             =   fopen($saveFilePath, 'wb');       
             $contents['flerror_path'] = "error/".$fileName;
             fwrite($fp, $payment);
             fclose($fp);
             echo $CurPageURL.'/'.$contents['flerror_path'];	 
             throw new \RuntimeException('Error unable to get a  : check your credentials and try again Or contact the developper !');
     
        }
        $mpayment['is_mp'] = 1;
        $mp_resp_json = $n_json ? json_encode($payment) : $payment;
     
        return $mp_resp_json;
    }
    //  get the payment token
    public function get_paytoken()
    {   
        $ini_auth = new InitializeApi();
        $token_auth = $ini_auth->InitiatePayment();
        $paytoken = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_url . '/mp/init');
        curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded'); 
        curl_setopt($ch, CURLOPT_HEADER, 'Authorization: Bearer ' . $token_auth['TOKEN']);
        curl_setopt($ch, CURLOPT_HEADER, 'X-AUTH-TOKEN: ' . ORANGE_MONEY_XAUTH_TOKEN); 
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $auth_resp = json_decode(curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code != 200) {
            // get the current domaaine name
            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
            $CurPageURL = $protocol . $_SERVER['HTTP_HOST'];
            // save the error file
            $auth_resp = json_encode($auth_resp);
            $dir            =   'error/';	
            $fileName	   =    "error-".time()."-payToken.json";
            $saveFilePath   =   $dir . $fileName;
            $fp             =   fopen($saveFilePath, 'wb');       
            $contents['flerror_path'] = "error/".$fileName;
            fwrite($fp, $auth_resp);
            fclose($fp);
            echo 'error code : '.$http_code.', the bearer token is '. $token_auth['TOKEN'];	 
            throw new \RuntimeException('Error unable to get a payToken : check X-AUTH-TOKEN and try again Or contact the developper !');
        }
        $paytoken = $token_auth;
        $paytoken["payToken"] = $auth_resp->payToken;
        $paytoken["message"] = $auth_resp->message;
        return $paytoken;
    }
}
