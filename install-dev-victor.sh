#!/bin/bash
#
# Module install script for local dev.

magentoRootPath="/Users/$USER/Code/magento19/root"

rm $magentoRootPath/app/etc/modules/Wfn_ConcardisPay.xml
rm -R $magentoRootPath/app/code/local/Wfn/ConcardisPay/

cp -R ./src/app/etc/modules/Wfn_ConcardisPay.xml $magentoRootPath/app/etc/modules/Wfn_ConcardisPay.xml
cp -R ./src/app/code/local/Wfn/ConcardisPay/ $magentoRootPath/app/code/local/Wfn/ConcardisPay/
