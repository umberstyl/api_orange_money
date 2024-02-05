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


require_once 'InitializeApi.php';

class CashoutBlance
{
    private $Okey;
    private $OSecret;
    private $token_auth;
    private $API_url;
    public function __construct()
    {
        $this->Okey = ORANGE_MONEY_SANDBOX? ORANGE_MONEY_SANDBOX_KEY : ORANGE_MONEY_PROD_KEY;  
        $this->OSecret = ORANGE_MONEY_SANDBOX? ORANGE_MONEY_SANDBOX_SECRET : ORANGE_MONEY_PROD_SECRET; 
        $this->API_url  = ORANGE_MONEY_SANDBOX ? 'http://apiw.orange.cm/omcoreapis/1.0.2' : 'https://apiw.orange.cm/omcoreapis/1.0.2'; 

    }

    public function Cashout($args = [], $n_json = false)
    {
        // make a payment
        $mTokens = $this->get_ctoken();
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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $this->API_url . '/cashout/pay');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: ' . $mTokens['TYPE'] . ' ' . $mTokens['TOKEN']));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $payment = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $cs_payment = json_decode($payment, true);
        if ($http_code != 200) {
            throw new \RuntimeException('Error ' . $cs_payment->error . ': ' . $cs_payment->error_description);
        }
        $mpayment['is_mp'] = 0;
        $cs_resp_json = $n_json ? json_encode($payment) : $payment;
        return $cs_resp_json;
    }

    //  get a new token from the sercver
    public function get_ctoken()
    {
        $ini_auth = new InitializeApi();
        $token_auth = $ini_auth->InitiatePayment();
        $ctoken = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_url . '/cashout/init');
        curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: application/x-www-form-urlencoded'); 
        curl_setopt($ch, CURLOPT_HEADER, 'X-AUTH-TOKEN: ' . ORANGE_MONEY_XAUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HEADER, 'Authorization: Bearer ' . $token_auth['TOKEN']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_USERPWD, $this->Okey.":".$this->OSecret);  
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
            $fileName	   =    "error-".time()."-cashToken.json";
            $saveFilePath   =   $dir . $fileName;
            $fp             =   fopen($saveFilePath, 'wb');       
            $contents['flerror_path'] = "error/".$fileName;
            fwrite($fp, $auth_resp);
            fclose($fp);
            echo 'error code : '.$http_code.' bearer token : '. $token_auth['TOKEN'];	 
            throw new \RuntimeException('Error unable to get a cashout Token : check X-AUTH-TOKEN and try again Or contact the developper !');
        }
        $ctoken = $this->token_auth;
        $ctoken["payToken"] = $auth_resp->payToken;
        $ctoken["message"] = $auth_resp->message;
        return $ctoken;
    }
}
