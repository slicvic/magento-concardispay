<?php
/**
 * Interface Wfn_ConcardisPay_Api_Response_Interface
 */
interface Wfn_ConcardisPay_Api_Response_Interface
{
    /**
     * Get the HTTP status code.
     *
     * @return int
     */
    public function getHttpCode();

    /**
     * Get the response headers.
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Get the response body.
     *
     * @return string
     */
    public function getBody();

    /**
     * Get the transaction status code.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get the error code.
     *
     * @return string
     */
    public function getNcError();

    /**
     * Get the error description.
     *
     * @return string
     */
    public function getNcErrorPlus();
}