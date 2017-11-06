<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 12:14 AM
 */

namespace Thiru\Mpesa;


use Thiru\Mpesa\B2C\B2C;

use Thiru\Mpesa\C2B\C2B;

class Mpesa

{


    /**
     * Mpesa constructor.
     * @param B2CInterface $b2C
     * @param C2B $c2BRepository
     */
    public function __construct ()
    {

    }

    /**
     * @param $Amount
     * @param $PartyB
     * @param $Remarks
     * @return mixed
     */
    public static function sendMpesaMoney ($Amount, $PartyB, $Remarks)
    {
        $b2c = new B2C();
        return $b2c->sendMpesaMoney($Amount, $PartyB, $Remarks);
    }

    /**
     * @param $amount
     * @param $mobile
     * @param $account
     * @param $desc
     * @return mixed
     */
    public static function requestMpesaPayment ($amount, $mobile, $account, $desc)
    {
        $c2b = new C2B();

        return $c2b->requestMpesaPayment($amount, $mobile, $account, $desc);
    }

}