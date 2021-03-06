<?php
/**
 * Class Slicvic_ConcardisPay_Api_Request
 */
class Slicvic_ConcardisPay_Api_Request implements Slicvic_ConcardisPay_Api_Request_Interface
{
    const OPERATION_AUTHORIZE = 'RES';
    const OPERATION_CAPTURE   = 'SAS';
    const OPERATION_SALE      = 'SAL';
    const CURRENCY_USD        = 'USD';

    /**
     * API URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Request parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        return (isset($this->parameters[$name])) ? $this->parameters[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->parameters));
        $body = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);
        $response = new Slicvic_ConcardisPay_Api_Response($headers['http_code'], $headers, $body, $this);
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function sign($signingKey)
    {
        $hashString = '';
        $parameters = $this->parameters;
        unset($parameters['SHASIGN']);
        ksort($parameters);
        foreach ($parameters as $name => $value) {
            $hashString .= "$name=" . $value . $signingKey;
        }
        $this->parameters['SHASIGN'] = hash('sha256', $hashString);
        return $this;
    }
}