<?php
/**
 * API client.
 */
class Wfn_ConcardisPay_Api_Client implements Wfn_ConcardisPay_Api_ClientInterface
{
    const DEBUG_MODE = true;

    /**
     * {@inheritdoc}
     */
    public static function order(Mage_Sales_Model_Order_Payment $payment, $amount, Wfn_ConcardisPay_Model_Method_Cc $method)
    {
        $request = (new Wfn_ConcardisPay_Api_Order_Request($method->getConfigData('order_api_url')))
            ->setOperation(Wfn_ConcardisPay_Api_Order_Request::OPERATION_AUTHORIZE)
            ->setPspId($method->getConfigData('pspid'))
            ->setUserId($method->getConfigData('userid'))
            ->setPswd($method->getConfigData('pswd'))
            ->setOrderId($payment->getOrder()->getIncrementId())
            ->setAmount($amount)
            ->setCardno($payment->getCcNumber())
            ->setEd(sprintf('%02d%02d', $payment->getCcExpMonth(), substr($payment->getCcExpYear(), -2)))
            ->setCvc($payment->getCcCid());

        if ($method->getConfigData('payment_action') != Wfn_ConcardisPay_Model_Method_Cc::ACTION_AUTHORIZE) {
            $request->setOperation(Wfn_ConcardisPay_Api_Order_Request::OPERATION_SALE);
        }

        $response = $request
            ->sign($method->getConfigData('passphrase'))
            ->send();

        if (self::DEBUG_MODE) {
            $fh = fopen(Mage::getBaseDir() . '/concardis_order_request.log', 'w+');
            fwrite($fh, var_export($request, true));
            fwrite($fh, "\n\n");
            fwrite($fh, var_export($response, true));
            fclose($fh);
        }

        if (!$response->isOk()) {
            Mage::throwException(
                Mage::helper('wfnconcardispay')->__(
                    sprintf('There was an error processing your payment (Error: HTTP Status %s). Please contact us or try again.',
                        $response->getHttpCode()
                    )
                )
            );
        }

        if (!$response->isApproved()) {
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
}