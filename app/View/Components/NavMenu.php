<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavMenu extends Component
{
    public  $menuItems;
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menuItems = config('nav-menu');
        $this->user = auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-menu');
    }
}
