<?php

namespace TheCoderRaman\AssetsVersion\Contracts;

interface AssetsFinderInterface
{
    /**
     * Apply symfony finder options.
     *
     * @param array $options
     * @return $this
     */
    public function applyOptions(array $options): self;
}
