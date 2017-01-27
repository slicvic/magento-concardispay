<?php
/**
 * Interface Wfn_ConcardisPay_Api_Response_Interface
 */
interface Wfn_ConcardisPay_Api_Response_Interface
{
    /**
     * @return int
     */
    public function getHttpCode();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string
     */
    public function getBody();

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