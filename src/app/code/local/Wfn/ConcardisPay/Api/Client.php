<?php
/**
 * Class Wfn_ConcardisPay_Api_Client
 */
class Wfn_ConcardisPay_Api_Client implements Wfn_ConcardisPay_Api_Client_Interface
{
    /**
     * {@inheritdoc}
     */
    public function order(Mage_Sales_Model_Order_Payment $payment, $amount, Wfn_ConcardisPay_Model_Method_Cc $method)
    {
        $request = (new Wfn_ConcardisPay_Api_Request($method->getConfigData('order_api_url')))
            ->setParameter('CURRENCY', Wfn_ConcardisPay_Api_Request::CURRENCY_USD)
            ->setParameter('ECI', Wfn_ConcardisPay_Api_Request::ECI_ECOMMERCE)
            ->setParameter('PSPID', $method->getConfigData('pspid'))
            ->setParameter('USERID', $method->getConfigData('userid'))
            ->setParameter('PSWD', $method->getConfigData('pswd'))
            ->setParameter('ORDERID', $payment->getOrder()->getIncrementId())
            ->setParameter('AMOUNT', $amount * 100)
            ->setParameter('CARDNO', $payment->getCcNumber())
            ->setParameter('ED', sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), -2)))
            ->setParameter('CVC', $payment->getCcCid());

        if ($method->getConfigData('payment_action') == Wfn_ConcardisPay_Model_Method_Cc::ACTION_AUTHORIZE) {
            $request->setParameter('OPERATION', Wfn_ConcardisPay_Api_Request::OPERATION_AUTHORIZE);
        } else {
            $request->setParameter('OPERATION', Wfn_ConcardisPay_Api_Request::OPERATION_SALE);
        }

        $response = $request->send($method->getConfigData('passphrase'));

        $this->log(var_export($request, true));
        $this->log(var_export($response, true));

        if ($response->getHttpCode() != Wfn_ConcardisPay_Api_Response::HTTP_CODE_OK) {
            Mage::throwException(
                Mage::helper('wfnconcardispay')->__(
                    sprintf('There was an error processing your payment (Error: HTTP Status %s). Please contact us or try again.',
                        $response->getHttpCode()
                    )
                )
            );
        }

        $isApproved = (
                $response->getStatus() == Wfn_ConcardisPay_Api_Response::STATUS_AUTHORIZED
                || $response->getStatus() == Wfn_ConcardisPay_Api_Response::STATUS_PAYMENT_ACCEPTED
            );

        if (!$isApproved) {
            Mage::throwException(
                Mage::helper('wfnconcardispay')->__(
                    sprintf('There was an error processing your payment. %s (Status: %s, Error: %s)',
                        $response->getNcErrorPlus(),
                        $response->getStatus(),
                        $response->getNcError()
                    )
                )
            );
        }

        return $response;
    }

    /**
     * Log request data and response.
     *
     * @param string $message
     */
    private function log($message)
    {
        Mage::log($message . "\n\n", null, 'concardispay.log');
    }
}