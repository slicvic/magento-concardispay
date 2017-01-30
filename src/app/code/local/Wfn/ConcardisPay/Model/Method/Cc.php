<?php
/**
 * Class Wfn_ConcardisPay_Model_Method_Cc
 */
class Wfn_ConcardisPay_Model_Method_Cc extends Mage_Payment_Model_Method_Cc
{
    /**
     * {@inheritdoc}
     */
    protected $_code = 'wfn_concardis_cc';

    /**
     * {@inheritdoc}
     */
    protected $_canAuthorize = true;

    /**
     * {@inheritdoc}
     */
    protected $_canCapture = true;

    /**
     * Authorize a new order.
     *
     * {@inheritdoc}
     */
    public function authorize(Varien_Object $payment, $amount)
    {
        try {
            $client = new Wfn_ConcardisPay_Api_Client_Order(
                $this->getConfigData('order_api_url'),
                $this->getConfigData('api_pspid'),
                $this->getConfigData('api_userid'),
                $this->getConfigData('api_password'),
                $this->getConfigData('api_passphrase')
            );

            $response = $client->authorize(
                $amount,
                $payment->getOrder()->getIncrementId(),
                $payment->getCcNumber(),
                $payment->getCcExpMonth(),
                $payment->getCcExpYear(),
                $payment->getCcCid()
            );

            $payment
                ->setTransactionId($response->getPayId())
                ->setIsTransactionClosed(0);

            return $this;
        } catch (Wfn_ConcardisPay_Api_Exception $e) {
            $this->log($e);
            throw $e;
        } catch (Exception $e) {
            throw new Wfn_ConcardisPay_Api_Exception();
        }
    }

    /**
     * Authorize and capture a new order or capture existing order from backend.
     *
     * {@inheritdoc}
     */
    public function capture(Varien_Object $payment, $amount)
    {
        try {
            if ($payment->getOrder()->getStatusLabel()) {
                // Capture existing order from backend
                $client = new Wfn_ConcardisPay_Api_Client_Maintenance(
                    $this->getConfigData('maintenance_api_url'),
                    $this->getConfigData('api_pspid'),
                    $this->getConfigData('api_userid'),
                    $this->getConfigData('api_password'),
                    $this->getConfigData('api_passphrase')
                );

                $response = $client->capture($amount, $payment->getOrder()->getIncrementId());
            } else {
                // Authorize and capture a new order
                $client = new Wfn_ConcardisPay_Api_Client_Order(
                    $this->getConfigData('order_api_url'),
                    $this->getConfigData('api_pspid'),
                    $this->getConfigData('api_userid'),
                    $this->getConfigData('api_password'),
                    $this->getConfigData('api_passphrase')
                );

                $response = $client->authorizeAndCapture(
                    $amount,
                    $payment->getOrder()->getIncrementId(),
                    $payment->getCcNumber(),
                    $payment->getCcExpMonth(),
                    $payment->getCcExpYear(),
                    $payment->getCcCid()
                );
            }

            $payment
                ->setTransactionId($response->getPayId())
                ->setIsTransactionClosed(1);

            return $this;
        } catch (Wfn_ConcardisPay_Api_Exception $e) {
            $this->log($e);
            throw $e;
        } catch (Exception $e) {
            throw new Wfn_ConcardisPay_Api_Exception();
        }
    }

    /**
     * Log API exception.
     *
     * @param Wfn_ConcardisPay_Api_Exception $e
     */
    protected function log(Wfn_ConcardisPay_Api_Exception $e)
    {
        if ($ccNumber = $e->getResponse()->getRequest()->getParameter('CARDNO')) {
            // Mask CC number before logging
            $ccLast4 = 'xxxx-' . substr($ccNumber, -4);
            $e->getResponse()->getRequest()->setParameter('CARDNO', $ccLast4);
        }

        Mage::log(var_export($e->getResponse(), true) . "\n\n", null, 'concardispay.log');
    }
}