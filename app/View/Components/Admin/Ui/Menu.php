<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\View\Component;

class Menu extends Component
{
    public $name;
    public $route;
    public $icon;
    public $target;
    public $new;
    public $count;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$route,$icon,$target=0,$new=0,$count=0)
    {
        $this->name=$name;
        $this->route=$route;
        $this->icon=$icon;
        $this->target=\Helper::getTarget($target);
        $this->new=$new;
        $this->count=$count;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.ui.menu');
    }
}
