<?php

declare(strict_types=1);

namespace Tests\Mocks;

use Illuminate\Contracts\Support\Htmlable;

class MediaMock implements Htmlable
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function img()
    {
        return $this;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return sprintf('<img src="%s" />', $this->url);
    }
}
