<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @var string|array|null
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
     * @param string $label
     * @param string $name
     * @param string $id
     * @param string|array|null $options
     * @param string|null $addClass
     * @param bool $required
     * @param bool $disable
     * @param bool $multiple
     * @param string|null $value
     * @param bool $default
     */
    public function __construct(
        string $label,
        string $name,
        string $id,
        $options = null,
        string $addClass = null,
        bool   $required = false,
        bool   $disable = false,
        bool   $multiple = false,
        string $value = null,
        bool   $default = true
    ) {
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
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.select');
    }
}
