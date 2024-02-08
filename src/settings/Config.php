<?php

namespace Boorwin\OrangeMoney\settings;
/* ORANGE_MONEY REST API configuration 
 * You can generate API credentials from the ORANGE_MONEY developer panel. 
 * See your keys here: https://developer.ORANGE_MONEY.com/dashboard/ 
 */

class Config
{

    private $mode;
    private $userName;
    private $password;
    private $key;
    private $secret;
    private $xAuth;
    private $userMsisdn;
    private $codePin;
    private $callback;
    public function __construct()
    {
        // api set all static api variables here

        $this->set_mode_sandbox(false);
        $this->set_default_callback("afrikpay.com/default/callback");
        //--------------------------//
        $this->set_api_key("Bs7DsGh99hDYOnRhfyXpluJ6JWsa");
        $this->set_api_secret("SFakZewdx5YosN7GFLVtf5rpn5wa");
        $this->set_api_username("umberstyl");
        $this->set_api_password("@Us862377");
        $this->set_auth_basic("dW1iZXJzdHlsOkBVczg2MjM3Nw==");
        $this->set_x_auth("");
        $this->set_channelUserMsisdn("691301143");
        $this->set_pin_code("2222");

    }
    public function set_mode_sandbox($sandbox = false)
    {
        $this->mode = $sandbox;
    }

    public function get_mode_sandbox()
    {
        return $this->mode;
    }
    public function set_default_callback($calb)
    {
        $this->callback = $calb;
    }
    public function get_default_callback()
    {
        return  $this->callback ;
    }

    public function set_x_auth($xAuth)
    {
        $this->xAuth = $xAuth;
    }

    public function get_x_auth()
    {
        return $this->xAuth;
    }

    public function set_auth_basic($xAuth)
    {
        $this->xAuth = $xAuth;
    }

    public function get_auth_basic()
    {
        return $this->xAuth;
    }

    public function set_api_key($key)
    {
        $this->key = $key;
    }

    public function get_api_key()
    {
        return $this->key;
    }

    public function set_api_secret($secret)
    {
        $this->secret = $secret;
    }
    public function get_api_secret()
    {
        return $this->secret;
    }
    public function set_api_username($user)
    {
        $this->userName = $user;
    }

    public function get_api_username()
    {
        return $this->userName;
    }

    public function set_api_password($pass)
    {
        $this->password = $pass;
    }

    public function get_api_password()
    {
        return $this->password;
    }

    public function set_channelUserMsisdn($userMsisdn)
    {
        $this->userMsisdn = $userMsisdn;
    }

    public function get_channelUserMsisdn()
    {
        return $this->userMsisdn;
    }

    public function set_pin_code($pn)
    {
        $this->codePin = $pn;
    }

    public function get_pin_code()
    {
        return $this->codePin;
    }
}
