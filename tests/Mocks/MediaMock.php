<?php

namespace Tests\Mocks;

use ARKEcosystem\UserInterface\Support\Contracts\HasUrlAndConversions;

class MediaMock implements HasUrlAndConversions
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function hasGeneratedConversion(): bool
    {
        return false;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
