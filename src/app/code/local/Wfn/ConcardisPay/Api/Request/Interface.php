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
     * Get all parameters.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Set all parameters.
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters);

    /**
     * Execute a cURL request.
     *
     * @param string $signingKey
     * @return Wfn_ConcardisPay_Api_Response
     */
    public function send($signingKey);
}