<?php
/**
 * Payment method model.
 */
class Wfn_ConcardisPay_Model_Method extends Mage_Payment_Model_Method_Abstract
{
    /**
     * {@inheritdoc}
     */
    protected $_code = 'wfn_concardispay';

    /**
     * {@inheritdoc}
     */
    protected $_formBlockType = 'wfnconcardispay/form';

    /**
     * {@inheritdoc}
     */
    protected $_infoBlockType = 'wfnconcardispay/info';
}