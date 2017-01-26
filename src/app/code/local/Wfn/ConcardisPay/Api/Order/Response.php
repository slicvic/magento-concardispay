<?php
/**
 * Response from order gateway.
 */
class Wfn_ConcardisPay_Api_Order_Response extends Wfn_ConcardisPay_Api_Abstract_Response
{
    const STATUS_AUTHORIZED       = 5;
    const STATUS_PAYMENT_ACCEPTED = 9;

    /**
     * Check if transaction was approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return ($this->status == self::STATUS_AUTHORIZED || $this->status == self::STATUS_PAYMENT_ACCEPTED);
    }
}