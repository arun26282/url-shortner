<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Invite extends Component
{
    public $companies;
    public $users;
    /**
     * Create a new component instance.
     */
    public function __construct($companies =null, $users =null)
    {
        $this->companies = $companies;
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.invite');
    }
}
