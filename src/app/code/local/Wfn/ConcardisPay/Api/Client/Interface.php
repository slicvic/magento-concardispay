<?php
/**
 * Interface Wfn_ConcardisPay_Api_Client_Interface
 */
interface Wfn_ConcardisPay_Api_Client_Interface
{
    /**
     * Place an order.
     *
     * @param Mage_Sales_Model_Order_Payment $payment
     * @param float $amount
     * @param Wfn_ConcardisPay_Model_Method_Cc $method
     * @return Wfn_ConcardisPay_Api_Response
     * @throws Mage_Core_Exception
     */
    public function order(Mage_Sales_Model_Order_Payment $payment, $amount, Wfn_ConcardisPay_Model_Method_Cc $method);
}