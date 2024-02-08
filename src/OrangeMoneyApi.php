<?php 
/**  
 *  
 *  
 *  
 * @class   orange_money_php_api
 * @author Bernard baudouin um
 * @link     
 * @version 1.0.2 
 */  
namespace Boorwin\OrangeMoney;

use Boorwin\OrangeMoney\core;
use Boorwin\OrangeMoney\settings;
use Boorwin\OrangeMoney\api;

class OrangeMoneyApi{

    private $_data = [] ;
    private $jr_son = false;
    public function __construct($_data_json, $return_json_data = true)
    {
        $secured = new core\All_Funct();

        // api static variables 
        $conf = new settings\Config();
       
        // processing data 
        $_data_obj = json_decode($_data_json);
        $this->_data['referenceNumber'] = $secured->secure($_data_obj->referenceNumber, 'int');
        $this->_data['phone'] = $secured->secure($_data_obj->phone, 'int');
        $this->_data['amount'] = $secured->secure($_data_obj->amount, 'int');
        $this->_data['callback'] = $secured->is_empty($_data_obj->callback)? $conf->get_default_callback() : $_data_obj->callback;
        $this->_data['description'] = $secured->is_empty($_data_obj->description)? "Marchant payment" : $_data_obj->description;
        if(isset($_data_obj->paytoken)){
             $this->_data['paytoken'] = $secured->is_empty($_data_obj->paytoken) ? false : $_data_obj->paytoken;
        }
        $this->jr_son = $return_json_data;
    }

    //  proceed the marchant payment 
    public function deposite(){

        $mp =  new api\MarchandPayment();
         // return value: true for json and false for array
        return $mp->mpayment($this->_data, $this->jr_son);

    }
    //  proceed the cashout balance

    public function cashout(){
      
        $cs = new api\CashoutBlance();
         // return value: true for json and false for array
        return $cs->cashout($this->_data, $this->jr_son);
    }

    //  csheck the payment status
    public function check_status($data_arr = []){

        $cke = new api\TransactionStatus();
        // check the transacton data : paytoken of the transacton, type of transacton,
        // marchand or cashout, set it true if marchand or false if cashout,
        // return value: true for json and false for array
        $status = $cke->trStatus($data_arr['payToken'], $data_arr['is_mp'], $this->jr_son);
    }
    
}
