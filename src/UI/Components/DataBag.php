<?php

namespace ARKEcosystem\UserInterface\Components;

use ARKEcosystem\UserInterface\DataBags\ResolverFactory;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

final class DataBag extends Component
{
    private string $key;

    private string $resolver;

    private string $view;

    public function __construct(string $key, string $resolver, string $view)
    {
        $this->key      = $key;
        $this->resolver = $resolver;
        $this->view     = $view;
    }

    public function render(): \Illuminate\View\View
    {
        return View::make($this->view, ResolverFactory::make($this->resolver, $this->key));
    }
}
