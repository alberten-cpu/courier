<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class TitleAndBreadcrumb extends Component
{
    public $title;
    public $breadcrumbOn;
    public $breadcrumbs;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title,$breadcrumbOn=1,$breadcrumbs=null)
    {
        $this->title=$title;
        $this->breadcrumbOn=$breadcrumbOn;
        $this->breadcrumbs=\Helper::convertJson($breadcrumbs);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.title-and-breadcrumb');
    }
}
