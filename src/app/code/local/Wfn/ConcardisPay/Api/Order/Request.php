<?php
/**
 * Request to order gateway.
 */
class Wfn_ConcardisPay_Api_Order_Request extends Wfn_ConcardisPay_Api_Abstract_Request
{
    const OPERATION_AUTHORIZE = 'RES';
    const OPERATION_SALE      = 'SAL';

    /**
     * {@inheritdoc}
     */
    protected $parameters = [
        'CURRENCY'  => 'USD',
        'OPERATION' => 'RES',
        'ECI'       => '7',
        'PSPID'     => null,
        'USERID'    => null,
        'PSWD'      => null,
        'ORDERID'   => null,
        'AMOUNT'    => null,
        'CARDNO'    => null,
        'ED'        => null,
        'CVC'       => null,
        'SHASIGN'   => null
    ];

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->parameters));
        $body = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);
        return (new Wfn_ConcardisPay_Api_Order_Response($headers['http_code'], $headers, $body));
    }

    /**
     * Set PSPID parameter.
     *
     * @param string $pspId
     * @return $this
     */
    public function setPspId($pspId)
    {
        $this->parameters['PSPID'] = $pspId;
        return $this;
    }

    /**
     * Set ORDERID parameter.
     *
     * @param string $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->parameters['ORDERID'] = $orderId;
        return $this;
    }

    /**
     * Set USERID parameter.
     *
     * @param string $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->parameters['USERID'] = $userId;
        return $this;
    }

    /**
     * Set PSWD parameter.
     *
     * @param string $pswd
     * @return $this
     */
    public function setPswd($pswd)
    {
        $this->parameters['PSWD'] = $pswd;
        return $this;
    }

    /**
     * Set AMOUNT parameter.
     *
     * @param string $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->parameters['AMOUNT'] = ($amount * 100);
        return $this;
    }

    /**
     * Set CARDNO parameter.
     *
     * @param string $cardNo
     * @return $this
     */
    public function setCardNo($cardNo)
    {
        $this->parameters['CARDNO'] = $cardNo;
        return $this;
    }

    /**
     * Set ED parameter.
     *
     * @param string $ed
     * @return $this
     */
    public function setEd($ed)
    {
        $this->parameters['ED'] = $ed;
        return $this;
    }

    /**
     * Set CVC parameter.
     *
     * @param string $cvc
     * @return $this
     */
    public function setCvc($cvc)
    {
        $this->parameters['CVC'] = $cvc;
        return $this;
    }

    /**
     * Set OPERATION parameter.
     *
     * @param string $operation
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->parameters['OPERATION'] = $operation;
        return $this;
    }
}