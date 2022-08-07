<?php

namespace App\View\Components\Admin\Ui;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BootstrapSwitch extends Component
{
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
    public $onText;
    /**
     * @var string
     */
    public $offText;
    /**
     * @var string
     */
    public $label;
    /**
     * @var string
     */
    public $onColor;
    /**
     * @var string
     */
    public $offColor;
    /**
     * @var bool
     */
    public $value;
    /**
     * @var bool
     */
    public $disable;
    /**
     * @var bool
     */
    public $readonly;
    /**
     * @var string|null
     */
    public $other;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $id
     * @param string $onText
     * @param string $offText
     * @param string $label
     * @param string $onColor
     * @param string $offColor
     * @param bool $value
     * @param bool $disable
     * @param bool $readonly
     * @param string|null $other
     */
    public function __construct(string $name,
                                string $id,
                                string $onText = 'ON',
                                string $offText = 'OFF',
                                string $label = '&nbsp;',
                                string $onColor = 'primary',
                                string $offColor = 'default',
                                bool   $value = false,
                                bool   $disable = false,
                                bool   $readonly = false,
                                string $other = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->onText = $onText;
        $this->offText = $offText;
        $this->label = $label;
        $this->onColor = $onColor;
        $this->offColor = $offColor;
        $this->value = $value;
        $this->disable = $disable;
        $this->readonly = $readonly;
        $this->other = $other;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.ui.bootstrap-switch');
    }
}
