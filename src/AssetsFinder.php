<?php

namespace TheCoderRaman\AssetsVersion;

use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class AssetsFinder extends Finder
{
    /**
     * Construct assets finder class.
     *
     * @param array $options
     * @return void
     */
    public function __construct(array $options)
    {
        parent::__construct();
        $this->applyOptions($options);
    }

    /**
     * Apply symfony finder options.
     *
     * @param array $options
     * @return $this
     */
    public function applyOptions(array $options): self
    {
        collect($options)->filter(
            fn($value) => !empty($value)
        )->map(fn($value, $option) =>
            $this->{Str::of($option)->camel()->toString()}($value)
        );

        return $this;
    }
}