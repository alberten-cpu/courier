<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * @var string
     */
    public $label;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $id;
    /**
     * @var string|null
     */
    public $placeholder;
    /**
     * @var bool
     */
    public $required;
    /**
     * @var string|null
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label,
                                string $name,
                                string $id,
                                string $value = null,
                                string $placeholder = null,
                                bool   $required = false
                                )
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.ui.textarea');
    }
}