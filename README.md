# ConcardisPay Magento Module
A credit card payment method that's integrated with ConCardis PayEngine payment gateway.

## Installation via Composer
In order to pull in the module via composer you will need to create a `composer.json` file in your project root folder.

You need to add following lines to your project's composer.json to tell Composer to check out the module as well as [magento-composer-installer](https://github.com/Cotya/magento-composer-installer) to install the module.

Make sure to set `magento-root-dir` to the directory where your Magento resides (relative to your project's composer.json).
```
{
    "require": {
        "magento-hackathon/magento-composer-installer": "*",
        "slicvic/magento-concardispay": "master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/magento-hackathon/magento-composer-installer"
        },
        {
            "type": "vcs",
            "url": "https://github.com/slicvic/magento-concardispay.git"
        }
    ],
    "extra":{
        "magento-root-dir": ".",
        "magento-deploystrategy": "copy"
    }
}
```

## Snapshots

![Alt text](https://cloud.githubusercontent.com/assets/4705073/24683013/a873194a-196a-11e7-9878-4de28c03ae80.png)

![Alt text](https://cloud.githubusercontent.com/assets/4705073/24683015/a88198e4-196a-11e7-9151-9860eda01afb.png)

![Alt text](https://cloud.githubusercontent.com/assets/4705073/24683016/a8847136-196a-11e7-8e69-d939fb777206.png)

![Alt text](https://cloud.githubusercontent.com/assets/4705073/24683014/a8811590-196a-11e7-890d-bea072c3b590.png)
