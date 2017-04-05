#!/bin/bash
#
# Module install script for local dev.

magentoRootPath="/Users/$USER/Code/magento19/root"

rm $magentoRootPath/app/etc/modules/Slicvic_ConcardisPay.xml
rm -R $magentoRootPath/app/code/local/Slicvic/ConcardisPay/

cp -R ./src/app/etc/modules/Slicvic_ConcardisPay.xml $magentoRootPath/app/etc/modules/Slicvic_ConcardisPay.xml
cp -R ./src/app/code/local/Slicvic/ConcardisPay/ $magentoRootPath/app/code/local/Slicvic/ConcardisPay/
