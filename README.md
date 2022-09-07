E-Comprocessing Gateway Module for Shopware 6
=============================

This is a Payment Plugin for Shopware 6, that gives you the ability to process payments through E-Comprocessing's Payment Gateway - Genesis.

Requirements
------------

* Shopware 6.3.x, 6.4.x (Tested up to __6.4.10__)
* [GenesisPHP v1.20.1](https://github.com/GenesisGateway/genesis_php/releases/tag/1.20.1)

GenesisPHP Requirements
------------

* PHP version 5.5.9 or newer
* PHP Extensions:
    * [BCMath](https://php.net/bcmath)
    * [CURL](https://php.net/curl) (required, only if you use the curl network interface)
    * [Filter](https://php.net/filter)
    * [Hash](https://php.net/hash)
    * [XMLReader](https://php.net/xmlreader)
    * [XMLWriter](https://php.net/xmlwriter)

Installation (manual) via console
---------------------
* Download the archive with the desired release
* Extract the containing files into `<Shopware 6 Root>\custom\plugins\EcomprocessingGenesis`
* Navigate via the console to the Shopware 6 Root
* Check if Shopware 6 recognize the plugin

  ```$ php bin/console plugin:refresh```

  The output should contain the following row:

  | Plugin | Label | Version | Upgrade version | Author | Installed | Active | Upgradeable |
  | --- | --- | --- | --- | --- | --- | --- | --- |
  | EcomprocessingGenesis | ecomprocessing Genesis Plugin | x.x.x |  | ecomprocessing Ltd | No | No | No |

* Install and activate the plugin

```$ php bin/console plugin:install --activate EcomprocessingGenesis```

* Clear the cache

```$ php bin/console cache:clear```

Configuration
---------------------
### ecomprocessing Genesis Plugin
* Log-in into the Admin
* Go to
  * `Extenstions->My Extensions` via Shopware 6.4.x
  * `Settings->System->Plugins` via Shopware 6.3.x
* `Activate`, `Install`, `Uninstall`, etc.
* Choose `Config` and fill up the Credentials, choose Transaction Types, etc

### Checkout Payment Methods
* Log-in into the Admin
* Go to
  * `Extenstions->My Extensions` via Shopware 6.4.x
  * `Settings->System->Plugins` via Shopware 6.3.x
* Choose `Edit`
* Set `Active`, `Availability Rule`, etc

### Shop
* Log-in into the Admin
* Go to <Your Shop>
* Navigate to section `Payment and shipping`
* Add Payment Methods `E-Comprocessing Checkout`

Uninstall \*CAUTION\*
---------------------
When uninstalling, a message will appear asking if the plug-in data needs to be removed:
* **Yes** - Removes all saved Plugin data \***THIS CAN NOT BE UNDONE**\*
* **No** - The Plugin data remain untouched

Supported Transactions
---------------------
* ```E-Comprocessing Checkout``` Payment Method
  * __Alternative Payment Methods__
    * __PPRO__
      * __iDEAL__
    * __SOFORT__
  * __Credit Cards__
    * __Authorize__
    * __Authorize (3D-Secure)__
    * __Sale__
    * __Sale (3D-Secure)__
    * __EPS__
  * __Sepa Direct Debit__
    * __SDD Sale__
  * __Online Banking Payments__
    * __GiroPay__
    * __iDEAL__
    * __iDebit Payin__
  * __Mobile__
    * __Apple Pay__
    * __Google Pay__
  * __Wallets__
    * __PayPal__ 

_Note_: If you have trouble with your credentials or terminal configuration, get in touch with our [support] team

You're now ready to process payments through our gateway.

[support]: mailto:tech-support@e-comprocessing.com

