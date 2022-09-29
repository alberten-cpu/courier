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

use Closure;
use Helper;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TitleAndBreadcrumb extends Component
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var int
     */
    public $breadcrumbOn;
    /**
     * @var string
     */
    public $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param int $breadcrumbOn
     * @param string|null $breadcrumbs
     */
    public function __construct(string $title, int $breadcrumbOn = 1, string $breadcrumbs = null)
    {
        $this->title = $title;
        $this->breadcrumbOn = $breadcrumbOn;
        $this->breadcrumbs = Helper::convertJson($breadcrumbs);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.admin.title-and-breadcrumb');
    }
}
