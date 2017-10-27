<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 1:47 AM
 */
namespace Thiru\Mpesa\B2C;
interface B2CInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function sendMoney($data);
}