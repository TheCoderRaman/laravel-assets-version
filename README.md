# Assets Version
<p align="center">
  <a title="license" href="./LICENSE"><img src="https://img.shields.io/github/license/TheCoderRaman/laravel-assets-version" alt="license"></a>
  <a title="laravel" href="https://laravel.com"><img src="https://img.shields.io/badge/logo-laravel-blue?logo=laravel" alt="laravel"></a>
  <a title="laravel" href="https://packagist.org/packages/TheCoderRaman/laravel-assets-version"><img src="https://img.shields.io/packagist/v/TheCoderRaman/laravel-assets-version.svg?style=flat-square" alt="Latest Version on Packagist"></a>
</p>

<p align="center">
  <img width="200" height="200" src="./resources/logo.png?raw=true" alt="logo" />
</p>

<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="./resources/text-logo-dark.png?raw=true">
      <img alt="UyScuti" src="./resources/text-logo-light.png?raw=true">
  </picture>
</p>

## 🦸‍♂️ About
By incorporating query strings, Laravel assets version facilitates static assets versioning, as exemplified by the transformation of 
app.js into app.js?d41d8cd98f. This method allows for efficient cache busting, ensuring that updated versions of static assets are promptly 
recognized and utilized by web browsers. Through the addition of unique query strings, such as the appended d41d8cd98f, the system effectively 
distinguishes between different versions of the same static asset, thereby enhancing performance and reliability within web development projects.

Empower your web development with Laravel's dynamic assets versioning, seamlessly 
integrating query strings to ensure efficient cache busting and swift recognition of updated versions.

##### 👊 "Efficient cache busting with Laravel's dynamic versioning."

## Major Technologies
- laravel

## Structure
```sh
├───config
├───resources
├───src
│   ├───Console
│   ├───Contracts
│   ├───Helpers
│   └───Support
│       └───Facades
└───tests
    ├───Concerns
    ├───Feature
    └───Unit
```

### 💫 Requirements
* PHP >= 7.3 

## ⚜️ Features
* Supports multiple hash algorithms for generating asset file versions.
* Supports different filters for filtering asset files during asset version generation.
* Automatically assigns a version to asset URLs when using the `asset_path()` helper function..

## Getting Started 🎉
These instructions will get you a copy of the library up and running on your local machine for production and development purposes.

#### 👨‍💻 Production Environment

###### Install this package
```bash
$ composer require thecoderraman/laravel-assets-version
```

###### Publish the config file:
```bash
$ php artisan vendor:publish --tag=assets-version
```

###### Update Configuration File as Needed
```bash
edit: config/assets-version.php
```

###### Update Environment File as Needed
```bash
# Directory for assets
ASSET_PATH=assets
# Path to assets directory
ASSET_URL=http://localhost/assets
```

#### 🕹️ Library Basic Usage

##### You can get the versioned url of any asset file by using the `below` helper function:

###### Using Helper Functions
```php
# For Type Js
js_path('app.js');  // "assets/js/app.js?3085ede8f2"

# For Type Css
css_path('app.css');  // "assets/css/app.css?3ede8f2085"

# For Other Types
asset_path('images/logo.png');  // "assets/images/logo.png?e8f203ed85"
```

###### For Using inside laravel blade template
```php
<link href="{{ asset_path('js/app.js') }}" rel="stylesheet">
```

###### Using Facades
```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use TheCoderRaman\AssetsVersion\Support\Facades\AssetsVersion;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        // "assets/js/app.js?3085ede8f2"
        dump(AssetsVersion::jsPath('app.js'));

        // "assets/css/app.css?3ede8f2085"
        dump(AssetsVersion::cssPath('app.css'));

        // "assets/images/logo.png?e8f203ed85"
        dump(AssetsVersion::assetPath('images/logo.png'));
    }
}
```
:warning: **You have to run these commands every time you change any asset file content.**

###### Assets Version Commands
```bash
# For generating assets version cache file
$ php artisan assets-version:cache

# For removing assets version cached file
$ php artisan assets-version:clear
```

#### 🛠️ Development Environment

###### Clone this repository
```bash
$ git clone https://github.com/TheCoderRaman/laravel-assets-version.git
$ cd laravel-assets-version
$ composer install
```

###### PhpUnit Tests
```bash
# Run Tests
$ composer run-script phpunit
```

###### Testbench for testing integrations
```bash
# Use TestBench
$ composer run-script testbench
$ composer run-script testbench:serve
$ composer run-script testbench:build
$ composer run-script testbench:prepare
$ composer run-script testbench:clear
```

## Repository Branches
- **master** -> any pull request of changes this branch
- **main** -> don´t modify, this is what is running in production
## Contributions

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
Please make sure to update tests as appropriate.

###### Pull Requests
1. Fork the repo and create your branch:
   `#[type]/PR description`
1. Ensure to describe your pull request:
   Edit the PR title by adding a semantic prefix like `Added`, `Updated:`, `Fixed:` etc.
   **Title:**
   `#[issue] PR title -> #90 Fixed styles the button`
## Authors
* [Raman Verma](https://github.com/TheCoderRaman)

## Code of Conduct
In order to ensure that the Assets Version community is welcoming to all, please review and abide by the [Code of Conduct](./CODE_OF_CONDUCT.md).

## Security Vulnerabilities
If you discover a security vulnerability within Assets Version, please send an e-mail to Raman Verma via [e-mail](mailto:devramanverma@gmail.com).
All security vulnerabilities will be promptly addressed.

## License
The Assets Version is open-sourced software licensed under the [MIT License](./LICENSE)