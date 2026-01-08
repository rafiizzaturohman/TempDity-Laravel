<?php

namespace App\View\Components\Device;

use Illuminate\View\Component;

class Icon extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('components.device.icon');
    }
}
