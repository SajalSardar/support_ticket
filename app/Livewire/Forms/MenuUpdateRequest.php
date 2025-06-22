<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuUpdateRequest extends Form
{
    public $name      = '';
    public $parent_id = null;
    public $route     = '';
    public $url       = '';
    public $icon      = '';
    public $role      = [];
    public $status    = 'active';
}
