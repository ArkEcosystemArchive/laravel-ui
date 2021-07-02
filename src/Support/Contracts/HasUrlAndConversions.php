<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Support\Contracts;

interface HasUrlAndConversions
{
    public function hasGeneratedConversion(): bool;

    public function getUrl(): string;
}
