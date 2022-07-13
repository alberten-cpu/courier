<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\View\Component;

class Select extends Component
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
     * @var array|null
     */
    public $options;
    /**
     * @var string|null
     */
    public $addClass;
    /**
     * @var bool
     */
    public $disable;
    /**
     * @var bool
     */
    public $required;
    /**
     * @var bool
     */
    public $multiple;
    /**
     * @var string|null
     */
    public $value;
    /**
     * @var bool
     */
    public $default;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label, string $name, string $id ,array $options = [],string $addClass=null,
                                bool $required = false , bool $disable = false , bool $multiple = false ,
                                string $value = null,bool $default = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->options = $options;
        $this->addClass = $addClass;
        $this->required = $required;
        $this->disable = $disable;
        $this->multiple = $multiple;
        $this->value = $value;
        $this->default = $default;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.ui.select');
    }
}
