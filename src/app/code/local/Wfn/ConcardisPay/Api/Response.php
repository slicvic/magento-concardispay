<?php
/**
 * Class Wfn_ConcardisPay_Api_Response
 */
class Wfn_ConcardisPay_Api_Response implements Wfn_ConcardisPay_Api_Response_Interface
{
    const HTTP_CODE_OK              = 200;
    const STATUS_AUTHORIZED         = 5;
    const STATUS_PAYMENT_REQUESTED  = 9;
    const STATUS_PAYMENT_PROCESSING = 91;

    /**
     * HTTP status code.
     *
     * @var int
     */
    protected $httpCode;

    /**
     * Raw response headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Raw response body.
     *
     * @var string
     */
    protected $rawResponse;

    /**
     * Original request.
     *
     * @var Wfn_ConcardisPay_Api_Request_Interface
     */
    protected $request;

    /**
     * Transaction status code.
     *
     * @var string
     */
    protected $status;

    /**
     * Payment reference ID.
     *
     * @var string
     */
    protected $payId;

    /**
     * Transaction error code.
     *
     * @var string
     */
    protected $ncError;

    /**
     * Transaction error description.
     *
     * @var string
     */
    protected $ncErrorPlus;

    /**
     * Constructor.
     *
     * @param string $httpCode
     * @param array  $headers
     * @param string $rawResponse
     * @param Wfn_ConcardisPay_Api_Request_Interface $request
     */
    public function __construct($httpCode, $headers, $rawResponse, Wfn_ConcardisPay_Api_Request_Interface $request)
    {
        $this->httpCode = (int) $httpCode;
        $this->headers = $headers;
        $this->rawResponse = $rawResponse;
        $this->request = $request;

        $transactionData = simplexml_load_string($this->rawResponse);
        if ($transactionData === false) {
            return;
        }
        $this->status = (isset($transactionData['STATUS'])) ? (string) $transactionData['STATUS'] : null;
        $this->payId = (isset($transactionData['PAYID'])) ? (string) $transactionData['PAYID'] : null;
        $this->ncError = (isset($transactionData['NCERROR'])) ? (string) $transactionData['NCERROR'] : null;
        $this->ncErrorPlus = (isset($transactionData['NCERRORPLUS'])) ? (string) $transactionData['NCERRORPLUS'] : null;
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
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return $this->request;
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
    public function getPayId()
    {
        return $this->payId;
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