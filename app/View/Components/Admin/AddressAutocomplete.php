<?php

/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
 *
 * @category Component
 *
 * @package Laravel
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 *
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 28/08/22
 * */

namespace App\View\Components\Admin;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
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
     * @var false|mixed
     */
    public $noRelation;

    /**
     * Create a new component instance.
     *
     * @param string|null $inputId
     * @param object|null $editData
     * @param string $relations
     * @param bool $noRelation
     */
    public function __construct(
        string $inputId = null,
        object $editData = null,
        string $relations = 'defaultAddress',
        bool   $noRelation = false
    ) {
        $this->inputId = $inputId;
        $this->editData = $editData;
        $this->relations = $relations;
        $this->noRelation = $noRelation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.address-autocomplete');
    }
}
