<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Abstract
 */
abstract class Wfn_ConcardisPay_Api_Client_Abstract
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $pspId;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * @param string $url
     * @param string $pspId
     * @param string $user
     * @param string $password
     * @param string $passphrase
     */
    public function __construct($url, $pspId, $user, $password, $passphrase)
    {
        $this->url = $url;
        $this->pspId = $pspId;
        $this->user = $user;
        $this->password = $password;
        $this->passphrase = $passphrase;
    }

    /**
     * @param Wfn_ConcardisPay_Api_Response_Interface $response
     * @param array $successStatuses
     * @throws Mage_Core_Exception
     */
    protected function processResponse(Wfn_ConcardisPay_Api_Response_Interface $response, array $successStatuses)
    {
        if ($response->getHttpCode() != $response::HTTP_CODE_OK) {
            $this->throwException(sprintf(
                'There was an error processing your payment (Error: HTTP Status %s). Please contact us or try again.',
                $response->getHttpCode()
            ));
        }

        if (!in_array($response->getStatus(), $successStatuses)) {
            $this->throwException(sprintf('There was an error processing your payment. %s (Status: %s, NCError: %s)',
                $response->getNcErrorPlus(),
                $response->getStatus(),
                $response->getNcError()
            ));
        }
    }

    /**
     * @param string $message
     * @throws Mage_Core_Exception
     */
    protected function throwException($message)
    {
        Mage::throwException(Mage::helper('wfnconcardispay')->__($message));
    }
}