<?php
/**
 * Represents a request being sent to the payment gateway.
 */
class Wfn_ConcardisPay_Api_Request
{
    protected $gatewayUrl;
    protected $pspId;
    protected $userId;
    protected $pswd;
    protected $orderId;
    protected $amount;
    protected $cardNo;
    protected $ed;
    protected $cvc;
    protected $currency = 'USD';
    protected $surgery = 'RES';
    protected $eci = 7;

    /**
     * Execute the request.
     *
     * @return Wfn_ConcardisPay_Api_Response
     */
    public function execute()
    {
        $params = [
            'PSPID'    => $this->pspId,
            'USERID'   => $this->userId,
            'PSWD'     => $this->pswd,
            'ORDERID'  => $this->orderId,
            'AMOUNT'   => $this->amount,
            'CARDNO'   => $this->cardNo,
            'ED'       => $this->ed,
            'CVC'      => $this->cvc,
            'CURRENCY' => $this->currency,
            'SURGERY'  => $this->surgery,
            'ECI'      => $this->eci
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->gatewayUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $body = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        return Wfn_ConcardisPay_Api_Response::create($headers, $body);
    }

    /**
     * Getters and setters.
     */

    public function setGatewayUrl($gatewayUrl)
    {
        $this->gatewayUrl = $gatewayUrl;
        return $this;
    }

    public function setPspId($pspId)
    {
        $this->pspId = $pspId;
        return $this;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function setPswd($pswd)
    {
        $this->pswd = $pswd;
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = ($amount * 100);
        return $this;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function setCardNo($cardNo)
    {
        $this->cardNo = $cardNo;
        return $this;
    }

    public function setEd($ed)
    {
        $this->ed = $ed;
        return $this;
    }

    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
        return $this;
    }

    public function setSurgery($surgery)
    {
        $this->surgery = $surgery;
        return $this;
    }
}