============MPESA API=================

composer require thiru/mpesa

Add  \Thiru\Mpesa\MpesaServiceProvider::class on config/app.php

php artisan vendor:publish --tag=config


The laravel mpesa Package is open-sourced software licensed under the MIT license.

B2C

Mpesa::sendMpesaPayment('1000','956555', 'Salary 2017');//$amount,$paybill,$remark


C2B

Mpesa::requestMpesaPayment($amount, $mobile, $account, $desc)