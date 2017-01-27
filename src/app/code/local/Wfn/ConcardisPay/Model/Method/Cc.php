<?php
/**
 * Class Wfn_ConcardisPay_Model_Method_Cc
 */
class Wfn_ConcardisPay_Model_Method_Cc extends Mage_Payment_Model_Method_Cc
{
    /**
     * {@inheritdoc}
     */
    protected $_code = 'wfn_concardis_cc';

    /**
     * {@inheritdoc}
     */
    protected $_canAuthorize = true;

    /**
     * {@inheritdoc}
     */
    protected $_canCapture = true;

    /**
     * {@inheritdoc}
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        $client = (new Wfn_ConcardisPay_Api_Client_Order(
            $this->getConfigData('order_api_url'),
            $this->getConfigData('api_pspid'),
            $this->getConfigData('api_user'),
            $this->getConfigData('api_password'),
            $this->getConfigData('api_passphrase')
            ))
            ->setOperation(Wfn_ConcardisPay_Api_Request::OPERATION_AUTHORIZE)
            ->setOrderId($payment->getOrder()->getIncrementId())
            ->setAmount($amount)
            ->setCardNo($payment->getCcNumber())
            ->setEd($payment->getCcExpMonth(), $payment->getCcExpYear())
            ->setCvc($payment->getCcCid())
            ->sendRequest();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function capture(Varien_Object $payment, $amount)
    {
        // Capture a new order
        if (!$payment->getOrder()->getStatusLabel()) {
            $client = (new Wfn_ConcardisPay_Api_Client_Order(
                $this->getConfigData('order_api_url'),
                $this->getConfigData('api_pspid'),
                $this->getConfigData('api_user'),
                $this->getConfigData('api_password'),
                $this->getConfigData('api_passphrase')
                ))
                ->setOperation(Wfn_ConcardisPay_Api_Request::OPERATION_SALE)
                ->setOrderId($payment->getOrder()->getIncrementId())
                ->setAmount($amount)
                ->setCardNo($payment->getCcNumber())
                ->setEd($payment->getCcExpMonth(), $payment->getCcExpYear())
                ->setCvc($payment->getCcCid())
                ->sendRequest();

            return $this;
        }

        // Capture existing order
        $client = (new Wfn_ConcardisPay_Api_Client_Maintenance(
            $this->getConfigData('maintenance_api_url'),
            $this->getConfigData('api_pspid'),
            $this->getConfigData('api_user'),
            $this->getConfigData('api_password'),
            $this->getConfigData('api_passphrase')
            ))
            ->setOperation(Wfn_ConcardisPay_Api_Request::OPERATION_CAPTURE)
            ->setOrderId($payment->getOrder()->getIncrementId())
            ->setAmount($amount)
            ->sendRequest();

        return $this;
    }
}