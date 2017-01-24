<?php
/**
 * Represents a response from the payment gateway.
 */
class Wfn_ConcardisPay_Api_Response
{
    /**
     * @var int
     */
    protected $httpCode;
    /**
     * @var string
     */
    protected $rawBody;
    /**
     * @var string
     */
    protected $orderId;
    /**
     * @var string
     */
    protected $payId;
    /**
     * @var string
     */
    protected $ncError;
    /**
     * @var string
     */
    protected $status;

    /**
     * Factory.
     *
     * @param string $httpCode
     * @param string $rawBody
     * @return Wfn_ConcardisPay_Api_Response
     */
    public static function create($httpCode, $rawBody)
    {
        return new static($httpCode, $rawBody);
    }

    /**
     * Constructor.
     *
     * @param string $httpCode
     * @param string $rawBody
     */
    public function __construct($httpCode, $rawBody)
    {
        $this->httpCode = (int) $httpCode;
        $this->rawBody = $rawBody;
        $this->parseRawBody();
    }

    /**
     * Return raw body.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->rawBody;
    }

    /**
     * Parse the raw response body.
     */
    protected function parseRawBody()
    {
        $xml = simplexml_load_string($this->rawBody);

        if (false === $xml) {
            return;
        }

        $this
            ->setOrderId(isset($xml['orderID']) ? $xml['orderID'] : null)
            ->setPayId(isset($xml['PAYID']) ? $xml['PAYID'] : null)
            ->setNcError(isset($xml['NCERROR']) ? $xml['NCERROR'] : null)
            ->setStatus(isset($xml['STATUS']) ? $xml['STATUS'] : null);
    }

    /**
     * Getters and setters.
     */

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getBody()
    {
        return $this->rawBody;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getPayId()
    {
        return $this->payId;
    }

    public function setPayId($payId)
    {
        $this->payId = $payId;
        return $this;
    }

    public function getNcError()
    {
        return $this->ncError;
    }

    public function setNcError($ncError)
    {
        $this->ncError = $ncError;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}