<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datatable extends Component
{
    public $dataTable;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($dataTable, $title)
    {
        $this->dataTable = $dataTable;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.datatable');
    }
}
