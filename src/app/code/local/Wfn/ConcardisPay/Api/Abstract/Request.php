<?php
/**
 * Abstract request to gateway.
 */
abstract class Wfn_ConcardisPay_Api_Abstract_Request
{
    /**
     * The request URL.
     *
     * @var string
     */
    protected $url;

    /**
     * The request parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Create a new request.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Submit the request.
     *
     * @return Wfn_ConcardisPay_Api_Abstract_Response
     */
    abstract public function send();

    /**
     * Sign the request.
     *
     * @param string $passphrase
     * @return $this
     */
    public function sign($passphrase)
    {
        $hashString = '';
        $parameters = $this->parameters;
        unset($parameters['SHASIGN']);
        ksort($parameters);
        foreach ($parameters as $name => $value) {
            $hashString .= "$name=" . $value . $passphrase;
        }
        $this->parameters['SHASIGN'] = hash('sha256', $hashString);
        return $this;
    }
}