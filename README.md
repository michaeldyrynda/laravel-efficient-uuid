# Laravel Efficient UUIDs
## v1.0.0

[![Build Status](https://travis-ci.org/michaeldyrynda/laravel-efficient-uuid.svg?branch=master)](https://travis-ci.org/michaeldyrynda/laravel-efficient-uuid)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/michaeldyrynda/laravel-efficient-uuid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/michaeldyrynda/laravel-efficient-uuid/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/michaeldyrynda/laravel-efficient-uuid/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/michaeldyrynda/laravel-efficient-uuid/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/v/stable)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)
[![Total Downloads](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/downloads)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)
[![License](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/license)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)

## Introduction

This package simply overrides the default grammar file for the given connection making the `uuid()` blueprint method return a `binary(16)` rather than the default `char(36)`.

MySQL is the only supported connection type, only because I've no experience with other drivers. I welcome any pull requests to implement this functionality for other database drivers.

Note that `doctrine/dbal` does not appear to support changing existing `uuid` fields, and doing so would cause your existing values to be truncated in any event.

For more information, check out [this post](https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/) on storing and working with UUID in an optimised manner.

Using UUIDs in Laravel is made super simple in combination with [laravel-model-uuid](https://github.com/michaeldyrynda/laravel-model-uuid).

## Installation

This package is installed via [Composer](https://getcomposer.org/). To install, run the following command.

```bash
composer require dyrynda/laravel-efficient-uuid
```

Register the service provider in your `config/app.php` configuration file:

```php
'providers' => [
    ...
    Dyrynda\Database\LaravelEfficientUuidServiceProvider::class,
],
```

There is nothing special needed for this to function, simply declare a `uuid` column type in your migration files. I indexing the UUID column if you plan on querying against it, but would avoid making it the primary key.

```php
Schema::create('posts', function (Blueprint $table) {
    $table->increments('id');
    $table->uuid('uuid')->index();
    $table->string('title');
    $table->text('body');
    $table->timestamps();
});
```

You will need to add a cast to your model when using [laravel-model-uuid](https://github.com/michaeldyrynda/laravel-model-uuid) in order to correctly set and retrieve UUID from your MySQL database with binary fields.

```php
<?php

namespace App;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use GeneratesUuid;

    protected $casts = ['uuid' => 'uuid'];
}
```

## Support

If you are having general issues with this package, feel free to contact me on [Twitter](https://twitter.com/michaeldyrynda).

If you believe you have found an issue, please report it using the [GitHub issue tracker](https://github.com/michaeldyrynda/laravel-efficient-uuid/issues), or better yet, fork the repository and submit a pull request.

If you're using this package, I'd love to hear your thoughts. Thanks!
