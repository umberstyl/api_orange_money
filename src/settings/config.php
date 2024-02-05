<?php 

/* ORANGE_MONEY REST API configuration 
 * You can generate API credentials from the ORANGE_MONEY developer panel. 
 * See your keys here: https://developer.ORANGE_MONEY.com/dashboard/ 
 */ 


class Config {

    private $amount;
    private $client_number;
    private $transaction_id;
    private $currency;
    private $node;
    private $Token ;
    private $AuthAPI; 
    private $AUT ;   
    
    public function __construct()
    {
         $this->Token   = ORANGE_MONEY_SANDBOX?'http://apiw.orange.cm/token':'https://apiw.orange.cm/token';  
         $this->AuthAPI = ORANGE_MONEY_SANDBOX?'http://apiw.orange.cm/omcoreapis/1.0.2':'https://apiw.orange.cm/omcoreapis/1.0.2'; 
         $this->node = ['marchand_payment', 'balance_cashout', 'check_transacton_status']; 
    }


    public function set_mode_type($setp){
          return $setp;
    }

    

}

?>