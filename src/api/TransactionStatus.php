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

class TransactionStatus
{
     
    private $token_auth;
    private $API_url;
    public function __construct()
    {
        $ini_auth = new InitializeApi();
        $this->API_url  = ORANGE_MONEY_SANDBOX ? 'http://apiw.orange.cm/omcoreapis/1.0.2' : 'https://apiw.orange.cm/omcoreapis/1.0.2';
        $this->token_auth  = $ini_auth->InitiatePayment();
    }
    //  csheck the payment status

    public function trStatus($paytoken, $n_json = false)
    {
        $ch = curl_init();
        $link = ($paytoken['is_mp'] > 0) ? '/mp/paymentstatus/' : '/cashout/paymentstatus/';
        curl_setopt($ch, CURLOPT_URL, $this->API_url . $link . $paytoken['payToken']);
        curl_setopt($ch, CURLOPT_HEADER, array('X-AUTH-TOKEN: ' . ORANGE_MONEY_XAUTH_TOKEN, 'Authorization: ' . $this->token_auth['TYPE'] . ' ' . $this->token_auth['TOKEN']));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $auth_resp_json = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $auth_resp = json_decode($auth_resp_json, true);
        if ($http_code != 200) {
            throw new \RuntimeException('Error ' . $auth_resp->message . ' : ' . $auth_resp->error_description);
        }
        $auth_resp_json = $n_json ? json_decode($auth_resp_json) : $auth_resp_json;
        return $auth_resp_json;
    }

}
