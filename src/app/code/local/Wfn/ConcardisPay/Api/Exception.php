<?php
/**
 * Class Wfn_ConcardisPay_Api_Exception
 */
class Wfn_ConcardisPay_Api_Exception extends Mage_Core_Exception
{
    /**
     * {@inherit}
     */
    protected $message = 'There was a problem processing your payment. Please contact us or try again.';

    /**
     * API response.
     *
     * @var Wfn_ConcardisPay_Api_Response_Interface
     */
    protected $response;

    /**
     * Get API response.
     *
     * @return Wfn_ConcardisPay_Api_Response_Interface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set API response.
     *
     * @param Wfn_ConcardisPay_Api_Response_Interface $response
     * @return $this
     */
    public function setResponse(Wfn_ConcardisPay_Api_Response_Interface $response)
    {
        $this->response = $response;
        return $this;
    }
}