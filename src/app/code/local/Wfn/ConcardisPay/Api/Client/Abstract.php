<?php
/**
 * Class Wfn_ConcardisPay_Api_Client_Abstract
 */
abstract class Wfn_ConcardisPay_Api_Client_Abstract
{
    protected $url;
    protected $pspId;
    protected $user;
    protected $password;
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

    protected function processResponse(Wfn_ConcardisPay_Api_Response_Interface $response, array $successStatuses)
    {
        if ($response->getHttpCode() != $response::HTTP_CODE_OK) {
            $this->throwException(sprintf(
                'There was an error processing your payment (Error: HTTP Status %s). Please contact us or try again.',
                $response->getHttpCode()
            ));
        }

        if (!in_array($response->getStatus(), $successStatuses)) {
            $this->throwException(sprintf('There was an error processing your payment. %s (Status: %s, Error: %s)',
                $response->getNcErrorPlus(),
                $response->getStatus(),
                $response->getNcError()
            ));
        }
    }

    protected function throwException($message)
    {
        Mage::throwException(Mage::helper('wfnconcardispay')->__($message));
    }
}