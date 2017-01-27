<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Maintenance
 *
 * Client for https://secure.payengine.de/ncol/test/maintenancedirect.asp
 */
class Wfn_ConcardisPay_Api_Client_Maintenance extends Wfn_ConcardisPay_Api_Client_Abstract
{
    /**
     * {@inheritdoc}
     */
    public function sendRequest()
    {
        parent::sendRequest();

        $isApproved = (
            $this->response->getStatus() == Wfn_ConcardisPay_Api_Response::STATUS_PAYMENT_PROCESSING
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
}