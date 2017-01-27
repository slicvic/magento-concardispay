<?php
/**
 * Class Wfn_ConcardisPay_Api_Response
 */
class Wfn_ConcardisPay_Api_Response implements Wfn_ConcardisPay_Api_Response_Interface
{
    const HTTP_CODE_OK               = 200;
    const STATUS_AUTHORIZED          = 5;
    const STATUS_PAYMENT_REQUESTED   = 9;
    const STATUS_PAYMENT_PROCESSING  = 91;

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
     * The response body.
     *
     * @var string
     */
    protected $body;

    /**
     * The transaction status code.
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
     * Constructor.
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

        $transactionData = simplexml_load_string($this->body);
        if ($transactionData === false) {
            return;
        }
        $this->status = (isset($transactionData['STATUS'])) ? $transactionData['STATUS'] : null;
        $this->ncError = (isset($transactionData['NCERROR'])) ? $transactionData['NCERROR'] : null;
        $this->ncErrorPlus = (isset($transactionData['NCERRORPLUS'])) ? $transactionData['NCERRORPLUS'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getNcError()
    {
        return $this->ncError;
    }

    /**
     * {@inheritdoc}
     */
    public function getNcErrorPlus()
    {
        return $this->ncErrorPlus;
    }
}