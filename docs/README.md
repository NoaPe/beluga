
# Home

[![Latest Version on Packagist](https://img.shields.io/packagist/v/noape/beluga.svg?style=flat-square)](https://packagist.org/packages/noape/beluga)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/noape/beluga/run-tests?label=tests)](https://github.com/noape/beluga/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/noape/beluga/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/noape/beluga/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/noape/beluga.svg?style=flat-square)](https://packagist.org/packages/noape/beluga)

This is a Laravel package for extend model system, generate form and display datas. This package and this documentation are at their beginning. If you want to parcipate to his development don't hesitate to contact me.

## Basic Usage

```php
// App\Http\Shells\UserShell.php

use NoaPe\Beluga\Shell;

/**
 * Extend your model with Shell object.
 */
class UserShell extends Shell
{
    //
}

```

## Installation

You can install the package via composer:

```bash
composer require noape/beluga
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="beluga-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="beluga-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * Schema path
     */
    'schema_path' => base_path().'/database/schemas',

    /**
     * Default schema information value.
     */
    'default_schema_properties' => [
        'id' => true,
        'timestamps' => true,
    ],

    /**
     * Default data properties.
     */
    'default_type' => 'String',

    'prefix' => 'beluga',
    'middleware' => ['web'],

    'table_prefix' => 'beluga_',

    /**
     * Shell namespace.
     */
    'shell_namespace' => 'App\\Shells',

    /**
     * Shell namespace for internal shell.
     */
    'internal_shell_namespace' => 'NoaPe\\Beluga\\Http\\Models',

    /**
     * Array who associate data type alias to the object.
     */
    'data_types' => [
        'String' => NoaPe\Beluga\DataTypes\BString::class,
        'Text' => NoaPe\Beluga\DataTypes\Text::class,
        'Integer' => NoaPe\Beluga\DataTypes\Integer::class,
        'Float' => NoaPe\Beluga\DataTypes\BFloat::class,
        'Boolean' => NoaPe\Beluga\DataTypes\Boolean::class,
        'Date' => NoaPe\Beluga\DataTypes\Date::class,
        'DateTime' => NoaPe\Beluga\DataTypes\DateTime::class,
        'Time' => NoaPe\Beluga\DataTypes\Time::class,
        'Timestamp' => NoaPe\Beluga\DataTypes\Timestamp::class,
        'File' => NoaPe\Beluga\DataTypes\File::class,
        'Image' => NoaPe\Beluga\DataTypes\Image::class,
        'Select' => NoaPe\Beluga\DataTypes\Select::class,
        'Json' => NoaPe\Beluga\DataTypes\Json::class,

        'BelongsTo' => NoaPe\Beluga\DataTypes\Relations\BelongsTo::class,
        'HasMany' => NoaPe\Beluga\DataTypes\Relations\HasMany::class,
        'HasOne' => NoaPe\Beluga\DataTypes\Relations\HasOne::class,

        'Geo\Position' => NoaPe\Beluga\DataTypes\Geo\Position::class,
        'Geo\Polyline' => NoaPe\Beluga\DataTypes\Geo\Polyline::class,
        'Geo\Polygon' => NoaPe\Beluga\DataTypes\Geo\Polygon::class,
    ],

    /**
     * Image path.
     */
    'image_path' => 'images',
];

```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="beluga-views"
```

## Usage

```php
$beluga = new NoaPe\Beluga();
echo $beluga->echoPhrase('Hello, NoaPe!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Noa Peguin](https://github.com/NoaPe)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
