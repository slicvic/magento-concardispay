<?php
/**
 * Class Slicvic_ConcardisPay_Api_Exception
 */
class Slicvic_ConcardisPay_Api_Exception extends Mage_Core_Exception
{
    /**
     * {@inherit}
     */
    protected $message = 'There was a problem processing your payment. Please contact us or try again.';

    /**
     * API response.
     *
     * @var Slicvic_ConcardisPay_Api_Response_Interface
     */
    protected $apiResponse;

    /**
     * Get API response.
     *
     * @return Slicvic_ConcardisPay_Api_Response_Interface
     */
    public function getApiResponse()
    {
        return $this->apiResponse;
    }

    /**
     * Set API response.
     *
     * @param Slicvic_ConcardisPay_Api_Response_Interface $response
     * @return $this
     */
    public function setApiResponse(Slicvic_ConcardisPay_Api_Response_Interface $response)
    {
        $this->apiResponse = $response;
        return $this;
    }
}