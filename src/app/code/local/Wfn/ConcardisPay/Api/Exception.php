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
    protected $apiResponse;

    /**
     * Get API response.
     *
     * @return Wfn_ConcardisPay_Api_Response_Interface
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Set API response.
     *
     * @param Wfn_ConcardisPay_Api_Response_Interface $response
     * @return $this
     */
    public function setApiResponse(Wfn_ConcardisPay_Api_Response_Interface $response)
    {
        $this->apiResponse = $response;
        return $this;
    }
}