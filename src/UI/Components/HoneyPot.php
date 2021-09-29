<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Lukeraymonddowning\Honey\Views\Honey;

final class HoneyPot extends Honey
{
    public function render()
    {
        return view('ark::honey-pot');
    }
}
