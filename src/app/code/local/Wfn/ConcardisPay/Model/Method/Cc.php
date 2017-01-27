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
     * Authorize a new order.
     *
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
        ))->authorize(
            $amount,
            $payment->getOrder()->getIncrementId(),
            $payment->getCcNumber(),
            $payment->getCcExpMonth(),
            $payment->getCcExpYear(),
            $payment->getCcCid()
        );

        return $this;
    }

    /**
     * Authorize and capture a new order or capture existing one.
     *
     * {@inheritdoc}
     */
    public function capture(Varien_Object $payment, $amount)
    {
        // Authorize and capture a new order
        if (!$payment->getOrder()->getStatusLabel()) {
            $client = (new Wfn_ConcardisPay_Api_Client_Order(
                $this->getConfigData('order_api_url'),
                $this->getConfigData('api_pspid'),
                $this->getConfigData('api_user'),
                $this->getConfigData('api_password'),
                $this->getConfigData('api_passphrase')
            ))->authorizeAndCapture(
                $amount,
                $payment->getOrder()->getIncrementId(),
                $payment->getCcNumber(),
                $payment->getCcExpMonth(),
                $payment->getCcExpYear(),
                $payment->getCcCid()
            );

            return $this;
        }

        // Capture existing order (from backend)
        $client = (new Wfn_ConcardisPay_Api_Client_Maintenance(
            $this->getConfigData('maintenance_api_url'),
            $this->getConfigData('api_pspid'),
            $this->getConfigData('api_user'),
            $this->getConfigData('api_password'),
            $this->getConfigData('api_passphrase')
        ))->capture(
            $amount,
            $payment->getOrder()->getIncrementId()
        );

        return $this;
    }
}