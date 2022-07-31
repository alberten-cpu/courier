<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddressAutocomplete extends Component
{
    /**
     * @var string
     */
    public $inputId;
    /**
     * @var object|null
     */
    public $editData;
    /**
     * @var string
     */
    public $relations;

    /**
     * Create a new component instance.
     *
     * @param string|null $inputId
     * @param object|null $data
     */
    public function __construct(string $inputId = null, object $editData = null, string $relations = 'defaultAddress')
    {
        $this->inputId = $inputId;
        $this->editData = $editData;
        $this->relations = $relations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.admin.address-autocomplete');
    }
}
