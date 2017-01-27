<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Order
 *
 * Client for  https://secure.payengine.de/ncol/test/orderdirect.asp
 */
class Wfn_ConcardisPay_Api_Client_Order extends Wfn_ConcardisPay_Api_Client_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function __construct($url, $pspId, $user, $password, $passphrase)
    {
        parent::__construct($url, $pspId, $user, $password, $passphrase);

        $this->request
            ->setParameter('CURRENCY', Wfn_ConcardisPay_Api_Request::CURRENCY_USD)
            ->setParameter('ECI', Wfn_ConcardisPay_Api_Request::ECI_ECOMMERCE);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest()
    {
        parent::sendRequest();

        $isApproved = (
            $this->response->getStatus() == Wfn_ConcardisPay_Api_Response::STATUS_AUTHORIZED
            || $this->response->getStatus() == Wfn_ConcardisPay_Api_Response::STATUS_PAYMENT_REQUESTED
        );

        if (!$isApproved) {
            $this->throwTransactionException();
        }
    }

    /**
     * Set operation parameter.
     *
     * @param string $operation
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->request->setParameter('OPERATION', $operation);
        return $this;
    }

    /**
     * Set order ID parameter.
     *
     * @param string $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->request->setParameter('ORDERID', $orderId);
        return $this;
    }

    /**
     * Set amount parameter.
     *
     * @param string $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->request->setParameter('AMOUNT', $amount * 100);
        return $this;
    }

    /**
     * Set card number parameter.
     *
     * @param string $cardNo
     * @return $this
     */
    public function setCardNo($cardNo)
    {
        $this->request->setParameter('CARDNO', $cardNo);
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
        $this->request->setParameter('CVC', $cvc);
        return $this;
    }

    /**
     * Set expiration date parameter.
     *
     * @param string $month
     * @param string $year
     * @return $this
     */
    public function setEd($month, $year)
    {
        $this->request->setParameter('ED', date('my', strtotime("$year-$month-01")));
        return $this;
    }
}