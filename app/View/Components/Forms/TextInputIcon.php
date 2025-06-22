<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextInputIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $type, public ?string $dir)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.forms.text-input-icon');
    }
}
