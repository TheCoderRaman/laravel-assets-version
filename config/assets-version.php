<?php

/*
|--------------------------------------------------------------------------
| Copyright (c) TheCoderRaman
|--------------------------------------------------------------------------
|
| For the full copyright and license information,
| please view the LICENSE file that was distributed with this source code.
|
| @see https://github.com/TheCoderRaman/laravel-assets-version
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | VERSIONED
    |--------------------------------------------------------------------------
    |
    | Here you can override the version of any asset file, providing you with
    | the flexibility to manage and control the specific versions
    | of asset files according to your requirements.
    |
    | @type array<string, int|string>
    |
    */

    'versioned' => [
        // 'asset_path' => 'YOUR_ASSET_VERSION'
    ],

    /*
    |--------------------------------------------------------------------------
    | HASH ALGORITHM
    |--------------------------------------------------------------------------
    |
    | The value specified in this context will act as the algorithm for hashing
    | the file, which in turn will be used for generating the file version hash.
    | This hash will only change if the file undergoes alterations.
    |
    | @type string
    | @example md5 and sha1
    */

    'hash_algorithm' => 'md5',

    /*
    |--------------------------------------------------------------------------
    | ASSET DIRECTORY
    |--------------------------------------------------------------------------
    |
    | The value specified here will serve as the root directory for all of
    | your assets. Consequently, all assets residing in this directory
    | will be versioned by the versioner, ensuring that each asset
    | is systematically assigned a version number.
    |
    | @type string
    |
    */

    'assets_path' => env('ASSET_PATH', "assets"),

    /*
    |--------------------------------------------------------------------------
    | SYMFONY FILE FINDER
    |--------------------------------------------------------------------------
    |
    | Here you can define symfony file finder configurations which will be
    | used during file search in specified assets directory path.
    |
    | NOTE:
    | You can use any file finder filter just use name as key and args as value
    |
    */

    "finder" => [

        /*
        |--------------------------------------------------------------------------
        | DEPTH
        |--------------------------------------------------------------------------
        |
        | Directory depth upto which versioning take place.
        |
        | @type string|array<string>
        | @example '== 0', '< 3' or ['> 2', '< 5']
        */

        'depth' => null,

        /*
        |--------------------------------------------------------------------------
        | EXCLUDE
        |--------------------------------------------------------------------------
        |
        | Directory that will be ignored during asset versioning.
        |
        | @type string|array
        | @example 'libs', 'vendor' or 'node_modules'
        */

        'exclude' => [
            // 'libs'
        ],

        /*
        |--------------------------------------------------------------------------
        | FILE SIZE
        |--------------------------------------------------------------------------
        |
        | Here you can specifiy rules that tests for file sizes.
        |
        | @type int|string|array<int|string>
        | @example '> 10K', '<= 1Ki' or ['> 10K', '< 20K']
        */

        'size' => [
            // '> 10K', '< 20K'
        ],

        /*
        |--------------------------------------------------------------------------
        | FILE DATE
        |--------------------------------------------------------------------------
        |
        | Here you can specifiy rules tests for file dates (last modified).
        |
        | @type string|array<string>
        | @example '>= 2005-10-15' or ['>= 2005-10-15', '<= 2006-05-27']
        */

        'date' => [
            // '>= 2005-10-15', '<= 2006-05-27'
        ],

        /*
        |--------------------------------------------------------------------------
        | NAME PATTERN
        |--------------------------------------------------------------------------
        |
        | Here you can specifiy rules that files must match.
        |
        | @type string|array<string>
        | @example '/\.php$/', '*.php' or ['test.py', 'test.php']
        */

        'name' => [
            // 'test.py', 'test.php'
        ],

        /*
        |--------------------------------------------------------------------------
        | NOT NAME PATTERN
        |--------------------------------------------------------------------------
        |
        | Here you can specifiy rules that files must not match. You can use
        | patterns (delimited with / sign), globs or simple strings.
        |
        | @type string|array<string>
        | @example '/\.php$/', '*.php' or ['test.py', 'test.php']
        */

        'notName' => [
            // 'test.py', 'test.php'
        ],
    ],
];
