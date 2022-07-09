<?php

namespace App\View\Components\Admin\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $btnName;
    /**
     * @var string
     */
    public $class;
    /**
     * @var bool
     */
    public $disable;
    /**
     * @var string|null
     */
    public $other;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $name
     * @param string $id
     * @param string $btnName
     * @param string $class
     * @param bool $disable
     * @param string|null $other
     */
    public function __construct(string $type,
                                string $name,
                                string $id,
                                string $btnName,
                                string $class = 'btn-primary',
                                bool   $disable = false,
                                string $other = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->btnName = $btnName;
        $this->class = $class;
        $this->disable = $disable;
        $this->other = $other;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.admin.ui.button');
    }
}
