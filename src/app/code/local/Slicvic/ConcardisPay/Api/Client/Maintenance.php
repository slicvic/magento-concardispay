<?php
/**
 * Class Slicvic_ConcardisPay_Api_Client_Maintenance
 *
 * Client for {@link https://secure.payengine.de/ncol/test/maintenancedirect.asp}
 */
class Slicvic_ConcardisPay_Api_Client_Maintenance extends Slicvic_ConcardisPay_Api_Client_Abstract
{
    /**
     * Capture given amount.
     *
     * @param float  $amount
     * @param string $orderId
     * @return Slicvic_ConcardisPay_Api_Response_Interface
     * @throws Slicvic_ConcardisPay_Api_Exception
     */
    public function capture($amount, $orderId)
    {
        $request = (new Slicvic_ConcardisPay_Api_Request($this->url))
            ->setParameter('OPERATION', Slicvic_ConcardisPay_Api_Request::OPERATION_CAPTURE)
            ->setParameter('AMOUNT', $amount * 100)
            ->setParameter('ORDERID', $orderId)
            ->setParameter('PSPID', $this->pspId)
            ->setParameter('USERID', $this->userId)
            ->setParameter('PSWD', $this->password)
            ->sign($this->passphrase);
        $response = $request->send();
        $this->processResponse($response, [$response::STATUS_PAYMENT_PROCESSING]);
        return $response;
    }
}