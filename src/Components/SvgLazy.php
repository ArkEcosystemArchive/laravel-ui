<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

final class SvgLazy extends Component
{
    private $name;

    private $class;

    public function __construct(string $name, string $class)
    {
        $this->name = $name;
        $this->class = $class;
    }

    public function render(): View
    {
        return view('ark::svg-lazy', [
            'name' => $this->name,
            'class' => $this->class,
        ]);
    }
}
