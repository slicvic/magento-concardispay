<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Order
 *
 * Client for {@link https://secure.payengine.de/ncol/test/orderdirect.asp}
 */
class Wfn_ConcardisPay_Api_Client_Order extends Wfn_ConcardisPay_Api_Client_Abstract
{
    /**
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Wfn_ConcardisPay_Api_Response_Interface
     * @throws Wfn_ConcardisPay_Api_Exception
     */
    public function authorize($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = $this->buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
            ->setParameter('OPERATION', Wfn_ConcardisPay_Api_Request::OPERATION_AUTHORIZE)
            ->sign($this->passphrase);
        $response = $request->send();
        $this->processResponse($response, [$response::STATUS_AUTHORIZED, $response::STATUS_PAYMENT_REQUESTED]);
        return $response;
    }

    /**
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Wfn_ConcardisPay_Api_Response_Interface
     * @throws Wfn_ConcardisPay_Api_Exception
     */
    public function authorizeAndCapture($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = $this->buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
            ->setParameter('OPERATION', Wfn_ConcardisPay_Api_Request::OPERATION_SALE)
            ->sign($this->passphrase);
        $response = $request->send();
        $this->processResponse($response, [$response::STATUS_AUTHORIZED, $response::STATUS_PAYMENT_REQUESTED]);
        return $response;
    }

    /**
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Wfn_ConcardisPay_Api_Request_Interface
     */
    private function buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = (new Wfn_ConcardisPay_Api_Request($this->url))
            ->setParameter('CURRENCY', Wfn_ConcardisPay_Api_Request::CURRENCY_USD)
            ->setParameter('ECI', Wfn_ConcardisPay_Api_Request::ECI_ECOMMERCE)
            ->setParameter('AMOUNT', $amount * 100)
            ->setParameter('ORDERID', $orderId)
            ->setParameter('CARDNO', $ccNumber)
            ->setParameter('ED', date('my', strtotime("$ccExpYear-$ccExpMonth-01")))
            ->setParameter('CVC', $ccCvc)
            ->setParameter('PSPID', $this->pspId)
            ->setParameter('USERID', $this->userId)
            ->setParameter('PSWD', $this->password);

        return $request;
    }
}