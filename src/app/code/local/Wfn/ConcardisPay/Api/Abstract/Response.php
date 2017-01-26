<?php
/**
 * Abstract response from gateway.
 */
abstract class Wfn_ConcardisPay_Api_Abstract_Response
{
    const HTTP_CODE_OK = 200;

    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $httpCode;

    /**
     * The response headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * The response raw body.
     *
     * @var string
     */
    protected $body;

    /**
     * The response decoded body.
     *
     * @var false|SimpleXMLElement
     */
    protected $decodedBody;

    /**
     * The transaction status.
     *
     * @var string
     */
    protected $status;

    /**
     * The error code.
     *
     * @var string
     */
    protected $ncError;

    /**
     * The error description.
     *
     * @var string
     */
    protected $ncErrorPlus;

    /**
     * Create a new response.
     *
     * @param string $httpCode
     * @param array $headers
     * @param string $body
     */
    public function __construct($httpCode, $headers, $body)
    {
        $this->httpCode = (int) $httpCode;
        $this->headers = $headers;
        $this->body = $body;
        $this->decodedBody = simplexml_load_string($body);

        if ($this->decodedBody !== false) {
            $this->status = (isset($this->decodedBody['STATUS'])) ? $this->decodedBody['STATUS'] : null;
            $this->ncError = (isset($this->decodedBody['NCERROR'])) ? $this->decodedBody['NCERROR'] : null;
            $this->ncErrorPlus = (isset($this->decodedBody['NCERRORPLUS'])) ? $this->decodedBody['NCERRORPLUS'] : null;
        }
    }

    /**
     * Check if HTTP status code is 200.
     *
     * @return bool
     */
    public function isOk()
    {
        return (static::HTTP_CODE_OK === $this->httpCode);
    }

    /**
     * Get HTTP status code.
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Get transaction status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get error code.
     *
     * @return string
     */
    public function getNcError()
    {
        return $this->ncError;
    }

    /**
     * Get error description.
     *
     * @return string
     */
    public function getNcErrorPlus()
    {
        return $this->ncErrorPlus;
    }
}