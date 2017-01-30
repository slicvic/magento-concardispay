<?php
/**
 * Interface Wfn_ConcardisPay_Api_Response_Interface
 */
interface Wfn_ConcardisPay_Api_Response_Interface
{
    /**
     * Get HTTP status code.
     *
     * @return int
     */
    public function getHttpCode();

    /**
     * Get raw headers.
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Get raw response body.
     *
     * @return string
     */
    public function getRawResponse();

    /**
     * Get original request.
     *
     * @return Wfn_ConcardisPay_Api_Request_Interface
     */
    public function getRequest();

    /**
     * Get payment reference ID.
     *
     * @return string
     */
    public function getPayId();

    /**
     * Get transaction status code.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get transaction error code.
     *
     * @return string
     */
    public function getNcError();

    /**
     * Get transaction error description.
     *
     * @return string
     */
    public function getNcErrorPlus();
}