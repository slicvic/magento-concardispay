<?php
/**
 * Interface Wfn_ConcardisPay_Api_Request_Interface
 */
interface Wfn_ConcardisPay_Api_Request_Interface
{
    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set the URL.
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Get a parameter.
     *
     * @param string $name
     * @return string|null
     */
    public function getParameter($name);

    /**
     * Set a parameter.
     *
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