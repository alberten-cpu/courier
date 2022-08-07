<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * @var string
     */
    public $label;
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
     * @var string|null
     */
    public $addClass;
    /**
     * @var string|null
     */
    public $placeholder;
    /**
     * @var bool
     */
    public $autocomplete;
    /**
     * @var bool
     */
    public $required;
    /**
     * @var bool
     */
    public $disable;
    /**
     * @var bool
     */
    public $readonly;
    /**
     * @var mixed|null
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param string $label
     * @param string $type
     * @param string $name
     * @param string $id
     * @param null $value
     * @param string|null $addClass
     * @param string|null $placeholder
     * @param bool $required
     * @param bool $readonly
     * @param bool $disable
     * @param bool $autocomplete
     */
    public function __construct(string $label,
                                string $type,
                                string $name,
                                string $id,
                                       $value = null,
                                string $addClass = null,
                                string $placeholder = null,
                                bool   $required = false,
                                bool   $readonly = false,
                                bool   $disable = false,
                                bool   $autocomplete = false)
    {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->addClass = $addClass;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->readonly = $readonly;
        $this->disable = $disable;
        $this->autocomplete = $autocomplete;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.input');
    }
}
