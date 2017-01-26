<?php
/**
 * Client interface.
 */
interface Wfn_ConcardisPay_Api_ClientInterface
{
    /**
     * Place an order with authorization or sale.
     *
     * @param Mage_Sales_Model_Order_Payment $payment
     * @param float $amount
     * @param Wfn_ConcardisPay_Model_Method_Cc $method
     * @return Wfn_ConcardisPay_Api_Order_Response
     * @throws Mage_Core_Exception
     */
    public static function order(Mage_Sales_Model_Order_Payment $payment, $amount, Wfn_ConcardisPay_Model_Method_Cc $method);
}

