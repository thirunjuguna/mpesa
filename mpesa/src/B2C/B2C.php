<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 1:47 AM
 */
namespace Thiru\Mpesa\B2C;

use Illuminate\Support\Facades\Config;

class B2C
{
    /**
     * @param $authUrl
     * @return mixed
     */
    public $authUrl;
    /**
     * @param $b2cUrl
     * @return mixed
     */
    protected $b2cUrl;
    /**
     * @param $publicKey
     * @return mixed
     */
    public $publicKey;
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
    public $InitiatorPassword;

    /**
     * @param $default_header
     * @return mixed
     */
    public $default_header = [
        'Content-Type: application/json'
    ];

    /**
     * @param $access_token
     * @return mixed
     */
    public $access_token;
    ////securityCred
    public  $SecurityCredentials;
    private $PartyA;
    public $QueueTimeOutURL;
    public $ResultURL;

    /**
     * C2B constructor.
     */
    public function __construct ()
    {
        $this->setAccessToken();
        $this->setInitiatorPassword($this->getInitiatorPassword());
        $this->setConsumerKey($this->getConsumerKey());
        $this->setConsumerSecret($this->getConsumerSecret());
        $this->setAuthUrl($this->getAuthUrl());
        $this->setB2cUrl($this->getB2cUrl());
        $this->setPartyA($this->getPartyA());
        $this->setQueueTimeOutURL($this->getQueueTimeOutURL());
        $this->setResultURL($this->getResultURL());


    }

    /**
     * @return mixed
     */
    public function getResultURL ()
    {
        return \config('mpesa.ResultURL');
    }

    /**
     * @param mixed $ResultURL
     */
    public function setResultURL ($ResultURL)
    {
        return $this->ResultURL = $ResultURL;
    }

    /**
     * @return mixed
     */
    public function getQueueTimeOutURL ()
    {
        return \config('mpesa.QueueTimeOutURL');
    }

    /**
     * @param mixed $QueueTimeOutURL
     */
    public function setQueueTimeOutURL ($QueueTimeOutURL)
    {
        $this->QueueTimeOutURL = $QueueTimeOutURL;
    }

    /**
     * @return mixed
     */
    public function getPartyA ()
    {
        return Config::get('mpesa.B2cShortCode');
    }

    /**
     * @param mixed $PartyA
     * @return B2C
     */
    public function setPartyA ($PartyA)
    {
        $this->PartyA = $PartyA;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultHeader ()
    {
        $header = $this->default_header;
        $header[] = 'Authorization: Bearer ' . $this->access_token;
        return $header;
    }
    /**
     * @param $data
     * @return mixed
     */
    public function sendMpesaMoney ($Amount,$PartyB, $Remarks)
    {
//Business To Customer

        $SecurityCredential=$this->SecurityCredentials;
        $QueueTimeOutURL = $this->QueueTimeOutURL;
        $data = [];
        $Occasion='';
        $data['InitiatorName'] =$this->InitiatorName;
        $data['CommandID'] ='BusinessPayment';
        $data['SecurityCredential']=$SecurityCredential;
        $data['QueueTimeOutURL'] = $QueueTimeOutURL;
        $data['ResultURL'] = $this->ResultURL;
        $data['Amount'] = $Amount;
        $data['PartyA'] = $this->PartyA;//Organization /MSISDN sending the transaction
        $data['PartyB'] = $PartyB;//MSISDN sending the transaction number MSISD without the plus sign
        $data['Remarks'] = $Remarks;
        $data['Occasion'] = $Occasion;

        $url = $this->b2c_url;
        $header = $this->getDefaultHeader();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($curl);


        return $response;


    }


    /**
     * @param mixed $access_token
     */
    public function setAccessToken ()
    {
        $url = $this->authUrl;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            $credentials = base64_encode("$this->ConsumerKey:$this->ConsumerSecret");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'Authorization: Basic ' . $credentials )); //setting a custom header
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $curl_response = json_decode(curl_exec($curl),true);
            //return $curl_response;

            return $this->access_token = $curl_response['access_token'];




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

        return Config('mpesa.is_live') == false ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
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
        return Config('mpesa.is_live') == true ? 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest' : 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
    }

    /**
     * @param mixed $b2cUrl
     */
    public function setB2cUrl ($b2cUrl)
    {
        $this->b2cUrl = $b2cUrl;
    }

    /**
     * @return string
     */
    public function setSecurityCredentials ()
    {
        // $publicKey = "PATH_TO_CERTICATE";
        $publicKey ='-----BEGIN CERTIFICATE-----
MIIGkzCCBXugAwIBAgIKXfBp5gAAAD+hNjANBgkqhkiG9w0BAQsFADBbMRMwEQYK
CZImiZPyLGQBGRYDbmV0MRkwFwYKCZImiZPyLGQBGRYJc2FmYXJpY29tMSkwJwYD
VQQDEyBTYWZhcmljb20gSW50ZXJuYWwgSXNzdWluZyBDQSAwMjAeFw0xNzA0MjUx
NjA3MjRaFw0xODAzMjExMzIwMTNaMIGNMQswCQYDVQQGEwJLRTEQMA4GA1UECBMH
TmFpcm9iaTEQMA4GA1UEBxMHTmFpcm9iaTEaMBgGA1UEChMRU2FmYXJpY29tIExp
bWl0ZWQxEzARBgNVBAsTClRlY2hub2xvZ3kxKTAnBgNVBAMTIGFwaWdlZS5hcGlj
YWxsZXIuc2FmYXJpY29tLmNvLmtlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEAoknIb5Tm1hxOVdFsOejAs6veAai32Zv442BLuOGkFKUeCUM2s0K8XEsU
t6BP25rQGNlTCTEqfdtRrym6bt5k0fTDscf0yMCoYzaxTh1mejg8rPO6bD8MJB0c
FWRUeLEyWjMeEPsYVSJFv7T58IdAn7/RhkrpBl1dT7SmIZfNVkIlD35+Cxgab+u7
+c7dHh6mWguEEoE3NbV7Xjl60zbD/Buvmu6i9EYz+27jNVPI6pRXHvp+ajIzTSsi
eD8Ztz1eoC9mphErasAGpMbR1sba9bM6hjw4tyTWnJDz7RdQQmnsW1NfFdYdK0qD
RKUX7SG6rQkBqVhndFve4SDFRq6wvQIDAQABo4IDJDCCAyAwHQYDVR0OBBYEFG2w
ycrgEBPFzPUZVjh8KoJ3EpuyMB8GA1UdIwQYMBaAFOsy1E9+YJo6mCBjug1evuh5
TtUkMIIBOwYDVR0fBIIBMjCCAS4wggEqoIIBJqCCASKGgdZsZGFwOi8vL0NOPVNh
ZmFyaWNvbSUyMEludGVybmFsJTIwSXNzdWluZyUyMENBJTIwMDIsQ049U1ZEVDNJ
U1NDQTAxLENOPUNEUCxDTj1QdWJsaWMlMjBLZXklMjBTZXJ2aWNlcyxDTj1TZXJ2
aWNlcyxDTj1Db25maWd1cmF0aW9uLERDPXNhZmFyaWNvbSxEQz1uZXQ/Y2VydGlm
aWNhdGVSZXZvY2F0aW9uTGlzdD9iYXNlP29iamVjdENsYXNzPWNSTERpc3RyaWJ1
dGlvblBvaW50hkdodHRwOi8vY3JsLnNhZmFyaWNvbS5jby5rZS9TYWZhcmljb20l
MjBJbnRlcm5hbCUyMElzc3VpbmclMjBDQSUyMDAyLmNybDCCAQkGCCsGAQUFBwEB
BIH8MIH5MIHJBggrBgEFBQcwAoaBvGxkYXA6Ly8vQ049U2FmYXJpY29tJTIwSW50
ZXJuYWwlMjBJc3N1aW5nJTIwQ0ElMjAwMixDTj1BSUEsQ049UHVibGljJTIwS2V5
JTIwU2VydmljZXMsQ049U2VydmljZXMsQ049Q29uZmlndXJhdGlvbixEQz1zYWZh
cmljb20sREM9bmV0P2NBQ2VydGlmaWNhdGU/YmFzZT9vYmplY3RDbGFzcz1jZXJ0
aWZpY2F0aW9uQXV0aG9yaXR5MCsGCCsGAQUFBzABhh9odHRwOi8vY3JsLnNhZmFy
aWNvbS5jby5rZS9vY3NwMAsGA1UdDwQEAwIFoDA9BgkrBgEEAYI3FQcEMDAuBiYr
BgEEAYI3FQiHz4xWhMLEA4XphTaE3tENhqCICGeGwcdsg7m5awIBZAIBDDAdBgNV
HSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEwJwYJKwYBBAGCNxUKBBowGDAKBggr
BgEFBQcDAjAKBggrBgEFBQcDATANBgkqhkiG9w0BAQsFAAOCAQEAC/hWx7KTwSYr
x2SOyyHNLTRmCnCJmqxA/Q+IzpW1mGtw4Sb/8jdsoWrDiYLxoKGkgkvmQmB2J3zU
ngzJIM2EeU921vbjLqX9sLWStZbNC2Udk5HEecdpe1AN/ltIoE09ntglUNINyCmf
zChs2maF0Rd/y5hGnMM9bX9ub0sqrkzL3ihfmv4vkXNxYR8k246ZZ8tjQEVsKehE
dqAmj8WYkYdWIHQlkKFP9ba0RJv7aBKb8/KP+qZ5hJip0I5Ey6JJ3wlEWRWUYUKh
gYoPHrJ92ToadnFCCpOlLKWc0xVxANofy6fqreOVboPO0qTAYpoXakmgeRNLUiar
0ah6M/q/KA==
-----END CERTIFICATE-----
';
//$plaintext = "Safaricom132!";
        $plaintext =$this->InitiatorPassword;

        openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);

        return $this->SecurityCredentials=base64_encode($encrypted);
    }


}