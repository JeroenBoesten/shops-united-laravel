# Laravel ShopUnited Wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeroenboesten/shops-united-laravel.svg?style=flat-square)](https://packagist.org/packages/jeroenboesten/shops-united-laravel)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JeroenBoesten/shops-united-laravel/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JeroenBoesten/shops-united-laravel/?branch=master)
[![StyleCI](https://github.styleci.io/repos/186664966/shield?branch=master)](https://github.styleci.io/repos/186664966)
[![Total Downloads](https://img.shields.io/packagist/dt/jeroenboesten/shops-united-laravel.svg?style=flat-square)](https://packagist.org/packages/jeroenboesten/shops-united-laravel)

This Laravel package functions as a wrapper for the Shops United API. 
To see more about the specific API visit: [Shops United API Docs.](https://login.shops-united.nl/api/docs.php) 

This package is not affiliated with, funded, or in any way associated with Shops United, but is maintained in spare time. 


## Installation

You can install the package via composer:

```bash
composer require jeroenboesten/shops-united-laravel
```

####Environment variables 
Add the UserId and API Key to your environment variables.
```text
SHOP_UNITED_ACCOUNT_ID=
SHOP_UNITED_API_KEY=
```
Optionally you can set if the ssl certificate should be verified, by adding a environment variable. 
By default the ssll certificate is verified on production but NOT verified on local environments.
```text
SHOPS_UNITED_VERIFY_SSL=true
```
## Usage
After you installed the package you start using it by creating an instance. 
After that you can select one of the available modules (`Shipments` or `Accounts`) and use the methods in there.
``` php
    $shopsUnited = new \JeroenBoesten\ShopsUnitedLaravel\ShopsUnitedLaravel(); // Create a new ShopsUnitedLaravel instance.
    $shopsUnited->accounts()->validate(); // Validates the API Key and User ID.
    $shopsUnited->shipments()->types(); // List all types of shipments that are available for the account, can be used for creating a new shipment.
    $shopsUnited->shipments()->list(); // Lists last 50 shipments.
```
To create a new shipment over the api you can use the `Shipments()->create()` method with first the mandatory fields and after that a array with optional parameters (for a list of optional parameters visit the [api docs](https://login.shops-united.nl/api/docs.php#zending)).
```php
$shopsUnited->shipments()->create("PostNL", "Standaard pakket", "Order Aanvraag: 1502", "Arno Niem", "Straatweg", "14", "1111AB", "Amsterdam", 1, 1, ['NietLeverenBijDeBuren' => true])
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email info@jeroenboesten.nl instead of using the issue tracker.

## Credits

- [Jeroen Boesten](https://github.com/jeroenboesten)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.