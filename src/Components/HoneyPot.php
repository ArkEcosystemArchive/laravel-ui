<?php


namespace Support\Components;

use Lukeraymonddowning\Honey\Views\Honey;

class HoneyPot extends Honey
{
    public function render()
    {
        return view("ark::honey-pot");
    }
}
