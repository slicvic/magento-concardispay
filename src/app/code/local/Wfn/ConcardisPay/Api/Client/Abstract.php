<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Abstract
 */
abstract class Wfn_ConcardisPay_Api_Client_Abstract
{
    const DEBUG_MODE = true;

    /**
     * @var Wfn_ConcardisPay_Api_Request
     */
    protected $request;

    /**
     * @var Wfn_ConcardisPay_Api_Response
     */
    protected $response;

    /**
     * Passphrase for signing request.
     *
     * @var string
     */
    protected $passphrase;

    /**
     * Constructor.
     *
     * @param string $url
     * @param string $pspId
     * @param string $user
     * @param string $password
     * @param string $passphrase
     */
    public function __construct($url, $pspId, $user, $password, $passphrase)
    {
        $this->passphrase = $passphrase;

        $this->request = (new Wfn_ConcardisPay_Api_Request($url))
            ->setParameter('PSPID', $pspId)
            ->setParameter('USERID', $user)
            ->setParameter('PSWD', $password);
    }
    /**
     * {@inheritdoc}
     */
    public function sendRequest()
    {
        $this->response = $this->request
            ->sign($this->passphrase)
            ->send();

        $this->debug();

        if ($this->response->getHttpCode() != Wfn_ConcardisPay_Api_Response::HTTP_CODE_OK) {
            $this->throwHttpStatusException();
        }
    }

    /**
     * Throw HTTP error exception.
     *
     * @throws Mage_Core_Exception
     */
    protected function throwHttpStatusException()
    {
        $this->throwException(sprintf(
            'There was an error processing your payment (Error: HTTP Status %s). Please contact us or try again.',
            $this->response->getHttpCode()
        ));
    }

    /**
     * Throw transaction error exception.
     *
     * @throws Mage_Core_Exception
     */
    protected function throwTransactionException()
    {
        $this->throwException(sprintf('There was an error processing your payment. %s (Status: %s, Error: %s)',
            $this->response->getNcErrorPlus(),
            $this->response->getStatus(),
            $this->response->getNcError()
        ));
    }

    /**
     * Throw exception.
     *
     * @param string $message
     * @throws Mage_Core_Exception
     */
    protected function throwException($message)
    {
        Mage::throwException(Mage::helper('wfnconcardispay')->__($message));
    }

    /**
     * Log request and response.
     */
    protected function debug()
    {
        if (!static::DEBUG_MODE) {
            return;
        }

        Mage::log(
            var_export($this->request, true) . "\n\n" . var_export($this->response, true),
            null,
            'concardispay.log'
        );
    }
}