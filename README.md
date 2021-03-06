# Magento ConcardisPay
A credit card payment method that's integrated with Concardis payment gateway.

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

## Screenshots

![Alt text](https://user-images.githubusercontent.com/4705073/33864803-81b05fda-debc-11e7-8488-93665f3b9c06.png)

![Alt text](https://user-images.githubusercontent.com/4705073/33864802-819d534a-debc-11e7-8348-afed43033ae2.png)

![Alt text](https://user-images.githubusercontent.com/4705073/33864858-be09eadc-debc-11e7-91a7-1bfa97ce0225.png)
