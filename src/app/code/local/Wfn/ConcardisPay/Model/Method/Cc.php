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
        $client = new Wfn_ConcardisPay_Api_Client();
        $client->order($payment, $amount, $this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function capture(Varien_Object $payment, $amount)
    {
        $client = new Wfn_ConcardisPay_Api_Client();
        $client->order($payment, $amount, $this);
        return $this;
    }
}