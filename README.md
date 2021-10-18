# Laravel Efficient UUIDs

[![Build Status](https://github.com/michaeldyrynda/laravel-nullable-fields/workflows/run-tests/badge.svg)](https://github.com/michaeldyrynda/laravel-nullable-fields/actions?query=workflow%3Arun-tests)
[![Latest Stable Version](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/v/stable)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)
[![Total Downloads](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/downloads)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)
[![License](https://poser.pugx.org/dyrynda/laravel-efficient-uuid/license)](https://packagist.org/packages/dyrynda/laravel-efficient-uuid)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen)](https://plant.treeware.earth/michaeldyrynda/laravel-efficient-uuid)

## Introduction

This package extends the default grammar file for the given MySQL connection adding an `efficientUuid` blueprint method that creates a `binary(16)` field.

As of 3.0, this package _no longer overrides_ Laravel's default `uuid` method, but rather adds a separate `efficientUuid` field, due to compatibility issues with Laravel Telescope (#11).

As of 4.0, this package uses a [custom cast](https://laravel.com/docs/7.x/eloquent-mutators#custom-casts) to provide casting functionality into your models.

> **Note**: This package purposely does not use [package discovery](https://laravel.com/docs/5.8/packages#package-discovery), as it makes changes to the MySQL schema file, which is something you should explicitly enable.

MySQL, SQLite, and PostgreSQL are the only supported connection types, although I welcome any pull requests to implement this functionality for other database drivers.

Note that `doctrine/dbal` does not appear to support changing existing `uuid` fields, and doing so would cause your existing values to be truncated in any event.

For more information, check out [this post](https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/) on storing and working with UUID in an optimised manner.

Using UUIDs in Laravel is made super simple in combination with [laravel-model-uuid](https://github.com/michaeldyrynda/laravel-model-uuid). Note that when using `laravel-model-uuid`, if you are not casting your UUIDs or calling the query builder directly, you'll need to use the `getBytes` method when setting the UUID on the database, otherwise your values will be truncated. Depending on your MySQL/MariaDB configuration, this may lead to application errors due to strict settings. See #1 for more information.

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
    $table->efficientUuid('uuid')->index();
    $table->string('title');
    $table->text('body');
    $table->timestamps();
});
```

You will need to add a cast to your model when using [laravel-model-uuid](https://github.com/michaeldyrynda/laravel-model-uuid) in order to correctly set and retrieve UUID from your MySQL database with binary fields.

```php
<?php

namespace App;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use GeneratesUuid;

    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];
}
```

### Validation

Should you wish to use the efficient UUID column as part of your validation strategy, you may use the `Exists` rule as normal.

```php
public function update(Request $request, User $user)
{
    $request->validate([
        // Using the Rule facade
        'uuid' => [Rule::exists(Post::class)],

        // Using Exists directly
        'custom_uuid' => [new Exists(Post::class)],
    ]);
}
```

## Support

If you are having general issues with this package, feel free to contact me on [Twitter](https://twitter.com/michaeldyrynda).

If you believe you have found an issue, please report it using the [GitHub issue tracker](https://github.com/michaeldyrynda/laravel-efficient-uuid/issues), or better yet, fork the repository and submit a pull request.

If you're using this package, I'd love to hear your thoughts. Thanks!

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you support this package and contribute to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees [here](https://plant.treeware.earth/michaeldyrynda/laravel-efficient-uuid)

Read more about Treeware at [treeware.earth](https://treeware.earth)
