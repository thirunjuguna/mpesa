<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 1:47 AM
 */
namespace Thiru\Mpesa\B2C;

class B2CRepository implements B2CInterface
{
    /**
     * @param $authUrl
     * @return mixed
     */
    protected $authUrl;
    /**
     * @param $b2cUrl
     * @return mixed
     */
    protected $b2cUrl;
    /**
     * @param $publicKey
     * @return mixed
     */
    protected $publicKey;
    /**
     * @param $ConsumerSecret
     * @return mixed
     */
    protected $ConsumerSecret;

    /**
     * @param $ConsumerKey
     * @return mixed
     */
    protected $ConsumerKey;


    /**
     * @param $InitiatorPassword
     * @return mixed
     */
    protected $InitiatorPassword;

    /**
     * @param $default_header
     * @return mixed
     */
    protected $default_header = [
        'Content-Type: application/json'
    ];

    /**
     * @param $access_token
     * @return mixed
     */
    protected $access_token;

    /**
     * B2CRepository constructor.
     */
    public function __construct ()
    {
        $this->setAccessToken();
        $this->setInitiatorPassword($this->getInitiatorPassword());
        $this->setConsumerKey($this->getConsumerKey());
        $this->setConsumerSecret($this->getConsumerSecret());
        $this->setAuthUrl($this->getAuthUrl());
        $this->setB2cUrl($this->getB2cUrl());

    }

    /**
     * @param $data
     * @return mixed
     */
    public function sendMoney ($data)
    {
        // TODO: Implement sendMoney() method.
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken ()
    {

    }

    /**
     * @param mixed $InitiatorPassword
     */
    public function setInitiatorPassword ($InitiatorPassword)
    {
        $this->InitiatorPassword = $InitiatorPassword;
    }

    /**
     * @return mixed
     */
    public function getInitiatorPassword ()
    {
        return Config("mpesa.InitiatorPassword");
    }
    /**
     * @return mixed
     */
    public function getConsumerKey ()
    {
        return Config("mpesa.B2cConsumerKey");
    }

    /**
     * @param mixed $ConsumerKey
     */
    public function setConsumerKey ($ConsumerKey)
    {
        $this->ConsumerKey = $ConsumerKey;
    }

    /**
     * @return mixed
     */
    public function getConsumerSecret ()
    {
        return Config("mpesa.B2cConsumerSecret");
    }

    /**
     * @param mixed $ConsumerSecret
     */
    public function setConsumerSecret ($ConsumerSecret)
    {
        $this->ConsumerSecret = $ConsumerSecret;
    }

    /**
     * @return mixed
     */
    public function getAuthUrl ()
    {

        return Config('mpesa.is_live') == false ? '' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        return $this->authUrl;
    }

    /**
     * @param mixed $authUrl
     */
    public function setAuthUrl ($authUrl)
    {
        $this->authUrl = $authUrl;
    }

    /**
     * @return mixed
     */
    public function getB2cUrl ()
    {
        return Config('mpesa.is_live') == true ? 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest' : '';
    }

    /**
     * @param mixed $b2cUrl
     */
    public function setB2cUrl ($b2cUrl)
    {
        $this->b2cUrl = $b2cUrl;
    }

}