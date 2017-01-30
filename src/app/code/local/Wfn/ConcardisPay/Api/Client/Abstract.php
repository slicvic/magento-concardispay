<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Abstract
 */
abstract class Wfn_ConcardisPay_Api_Client_Abstract
{
    /**
     * API URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Account PSP ID.
     *
     * @var string
     */
    protected $pspId;

    /**
     * Account user ID.
     *
     * @var string
     */
    protected $userId;

    /**
     * Account password.
     *
     * @var string
     */
    protected $password;

    /**
     * Account passphrase.
     *
     * @var string
     */
    protected $passphrase;

    /**
     * Constructor.
     *
     * @param string $url
     * @param string $pspId
     * @param string $userId
     * @param string $password
     * @param string $passphrase
     */
    public function __construct($url, $pspId, $userId, $password, $passphrase)
    {
        $this->url = $url;
        $this->pspId = $pspId;
        $this->userId = $userId;
        $this->password = $password;
        $this->passphrase = $passphrase;
    }

    /**
     * Process API response.
     *
     * @param Wfn_ConcardisPay_Api_Response_Interface $response
     * @param array $successStatus
     * @throws Wfn_ConcardisPay_Api_Exception
     */
    protected function processResponse(Wfn_ConcardisPay_Api_Response_Interface $response, array $successStatus)
    {
        if ($response->getHttpCode() != $response::HTTP_CODE_OK) {
            $this->throwException(sprintf(
                'There was a problem processing your payment. Please try again or contact us. (Error: HTTP status %s)',
                $response->getHttpCode()
            ), $response);
        }

        if (!in_array($response->getStatus(), $successStatus)) {
            $this->throwException(sprintf(
                'There was a problem processing your payment. Please try again or contact us. (Status: %s, Error: %s %s)',
                $response->getStatus(),
                $response->getNcError(),
                $response->getNcErrorPlus()
            ), $response);
        }
    }

    /**
     * Throw an exception with given message.
     *
     * @param string $message
     * @param Wfn_ConcardisPay_Api_Response_Interface $response
     * @throws Wfn_ConcardisPay_Api_Exception
     */
    protected function throwException($message, Wfn_ConcardisPay_Api_Response_Interface $response = null)
    {
        $exception = new Wfn_ConcardisPay_Api_Exception(Mage::helper('wfnconcardispay')->__($message));
        $exception->setApiResponse($response);
        throw $exception;
    }
}