# Laravel Audit Viewer #

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate/?hosted_button_id=6CYVR8U4VDMAA) ![Packagist Downloads](https://img.shields.io/packagist/dt/seinoxygen/audit-viewer?label=Downloads)

A simple audit viewer viewer for the package owen-it/laravel-auditing.

## Installation

Add Audit Viewer as a dependency using the composer CLI:

```bash
composer require seinoxygen/audit-viewer
```

## Publishing Assets

```bash
php artisan vendor:publish --provider="SeinOxygen\AuditViewer\AuditViewerServiceProvider" --tag=config

php artisan vendor:publish --provider="SeinOxygen\AuditViewer\AuditViewerServiceProvider" --tag=views

php artisan vendor:publish --provider="SeinOxygen\AuditViewer\AuditViewerServiceProvider" --tag=view-components

php artisan vendor:publish --provider="SeinOxygen\AuditViewer\AuditViewerServiceProvider" --tag=translations
```

## Basic Usage

If using < Laravel 5.5, add the AuditViewerServiceProvider to the providers array

```php
'providers' => [
    ...
    SeinOxygen\AuditViewer\AuditViewerServiceProvider::class,
    ...
],
```

Using your-url.com/audit-viewer you can have access to all audits saved on your database.

### Controllers

In your controller you'll need to add the AuditViewContract and the trait HasAudits.

Also you'll need to return the auditable model in the function setModel().

```php
<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SeinOxygen\AuditViewer\Contracts\AuditViewContract;
use SeinOxygen\AuditViewer\Http\Traits\HasAudits;

class BlogController extends Controller implements AuditViewContract
{
    use HasAudits;

    public function setModel()
    {
        return Blog::class;
    }
}
```

The trait automatically will add a function called audit($id) to the controller and you'll need to add that route manually to access all models audit.

### Routing

You'll need to add routes manually to your controllers.

```php
<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/blog/{model}/audit', [BlogController::class, 'audit']);
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
