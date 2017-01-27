<?php
/**
 * Interface Wfn_ConcardisPay_Api_Request_Interface
 */
interface Wfn_ConcardisPay_Api_Request_Interface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * @param string $name
     * @return string|null
     */
    public function getParameter($name);

    /**
     * @param string $name
     * @param string $value
     * @return string
     */
    public function setParameter($name, $value);

    /**
     * Execute a cURL request.
     *
     * @return Wfn_ConcardisPay_Api_Response
     */
    public function send();

    /**
     * Sign the request.
     *
     * @param string $signingKey
     * @return $this
     */
    public function sign($signingKey);
}