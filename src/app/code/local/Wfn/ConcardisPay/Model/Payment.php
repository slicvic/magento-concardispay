<?php
/**
 * Payment method model.
 */
class Wfn_ConcardisPay_Model_Payment extends Mage_Payment_Model_Method_Cc
{

    /**
     * {@inheritdoc}
     */
    protected $_code = 'wfn_concardispay';

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
        $response = $this->buildRequest($payment, $amount)
                         ->execute();

        Mage::throwException(Mage::helper('payment')->__('authorize xaction is not available.'.$response));
    }

    /**
     * {@inheritdoc}
     */
    public function capture(Varien_Object $payment, $amount)
    {
        $response = $this->buildRequest($payment, $amount)
            ->execute();

        Mage::throwException(Mage::helper('payment')->__('Capture action is not available.'));
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigPaymentAction()
    {
        return $this->getConfigData('payment_action');
    }

    /**
     * Prepare request to gateway.
     *
     * @param Varien_Object $payment
     * @param float $amount
     * @return Wfn_ConcardisPay_Api_Request
     */
    private function buildRequest(Varien_Object $payment, $amount)
    {
        $request = new Wfn_ConcardisPay_Api_Request();

        return $request
            ->setGatewayUrl('https://secure.payengine.de/ncol/test/orderdirect.asp')
            ->setPspId('111')
            ->setUserId('111')
            ->setPswd('111')
            ->setOrderId('111')
            ->setAmount('1111')
            ->setCardno('111')
            ->setEd('111')
            ->setCvc('111')
            ->setCurrency('111');
    }
}