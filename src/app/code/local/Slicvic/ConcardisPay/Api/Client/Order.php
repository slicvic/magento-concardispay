<?php
/**
 * Class Slicvic_ConcardisPay_Api_Client_Order
 *
 * Client for {@link https://secure.payengine.de/ncol/test/orderdirect.asp}
 */
class Slicvic_ConcardisPay_Api_Client_Order extends Slicvic_ConcardisPay_Api_Client_Abstract
{
    /**
     * Authorize given amount.
     *
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Slicvic_ConcardisPay_Api_Response_Interface
     * @throws Slicvic_ConcardisPay_Api_Exception
     */
    public function authorize($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = $this->buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
            ->setParameter('OPERATION', Slicvic_ConcardisPay_Api_Request::OPERATION_AUTHORIZE)
            ->sign($this->passphrase);
        $response = $request->send();
        $this->processResponse($response, [
            $response::STATUS_AUTHORIZED,
            $response::STATUS_PAYMENT_REQUESTED,
            $response::STATUS_AUTHORIZATION_WAITING
        ]);
        return $response;
    }

    /**
     * Authorize and capture given amount.
     *
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Slicvic_ConcardisPay_Api_Response_Interface
     * @throws Slicvic_ConcardisPay_Api_Exception
     */
    public function authorizeAndCapture($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = $this->buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
            ->setParameter('OPERATION', Slicvic_ConcardisPay_Api_Request::OPERATION_SALE)
            ->sign($this->passphrase);
        $response = $request->send();
        $this->processResponse($response, [
            $response::STATUS_AUTHORIZED,
            $response::STATUS_PAYMENT_REQUESTED,
            $response::STATUS_AUTHORIZATION_WAITING
        ]);
        return $response;
    }

    /**
     * Build request object.
     *
     * @param float  $amount
     * @param string $orderId
     * @param string $ccNumber
     * @param string $ccExpMonth
     * @param string $ccExpYear
     * @param string $ccCvc
     * @return Slicvic_ConcardisPay_Api_Request_Interface
     */
    private function buildRequest($amount, $orderId, $ccNumber, $ccExpMonth, $ccExpYear, $ccCvc)
    {
        $request = (new Slicvic_ConcardisPay_Api_Request($this->url))
            ->setParameter('CURRENCY', Slicvic_ConcardisPay_Api_Request::CURRENCY_USD)
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