<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 1:47 AM
 */
namespace Thiru\Mpesa\C2B;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Thiru\Mpesa\B2C\B2C;

class C2B
{

   protected $PartyA;
    private $passKey;
    private $CallBackURL;

    /**
     * C2B constructor.
     */
    public function __construct ()
    {
        $this->setPartyA($this->getPartyA());
        $this->setPassKey($this->getPassKey());
        $this->setCallBackURL($this->getCallBackURL());
    }

    /**
     * @return mixed
     */
    public function getCallBackURL ()
    {
        return \config('mpesa.CallBackURL');
    }

    /**
     * @param mixed $CallBackURL
     */
    public function setCallBackURL ($CallBackURL)
    {
        $this->CallBackURL = $CallBackURL;
    }

    /**
     * @return mixed
     */
    public function getPassKey ()
    {
        return \config('mpesa.PassKey');
    }

    /**
     * @param mixed $passKey
     */
    public function setPassKey ($passKey)
    {
        $this->passKey = $passKey;
    }

    /**
     * @return mixed
     */
    public function getPartyA ()
    {
        return Config::get('mpesa.C2bShortCode');
    }

    /**
     * @param mixed $PartyA
     */
    public function setPartyA ($PartyA)
    {
        $this->PartyA = $PartyA;
    }


    /**
     * @param $amount
     * @param $mobile
     * @param $account
     * @param $desc
     * @return mixed
     */
    public function requestMpesaPayment($amount, $mobile, $account, $desc){

        $Msisdn=$mobile;

        $data = [];
        $timestamp=Carbon::now()->format('YmdHis');
//////////////////////////////////
        $data['BusinessShortCode']=$this->PartyA;
        $data['Password']=base64_encode($this->PartyA.$this->passKey.$timestamp);
        $data["Timestamp"]=$timestamp;
        $data['TransactionType']='CustomerPayBillOnline';
        $data['Amount']=$amount;
        $data['PartyA']=$Msisdn;
        $data['PartyB']=$this->PartyA;
        $data['PhoneNumber']=$Msisdn;
        $data['CallBackURL']=$this->CallBackURL;
        $data['AccountReference']=$account;
        $data['TransactionDesc']=$desc;


        $url =$this->c2b_url;
        //$url = $this->queryStatus;
        $header = $this->getDefaultHeader();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        return  $response = curl_exec($curl);

    }

}