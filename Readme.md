MPESA API
=================
This is a LARAVEL PHP package for the Safaricom's M-Pesa API. The API allows a merchant to initiate C2B online checkout (paybill via web) transactions and perform B2C transaction via the web.

After request submission, the merchant receives instant feedback with validity status of their requests. The C2B API handles customer validation and authentication via USSD push. The customer then confirms the transaction. If the validation of the customer fails or the customer declines the transaction, the API makes a callback to merchant. Otherwise the transaction is processed and its status is made through a callback.

Installation
============================
composer `require thiru/mpesa`

Add  \Thiru\Mpesa\MpesaServiceProvider::class on config/app.php

`php artisan vendor:publish --tag=config`


The laravel mpesa Package is open-sourced software licensed under the MIT license.

B2C

`Mpesa::sendMpesaPayment('1000','956555', 'Salary 2017');//$amount,$paybill,$remark`


C2B

`Mpesa::requestMpesaPayment($amount, $mobile, $account, $desc)`
