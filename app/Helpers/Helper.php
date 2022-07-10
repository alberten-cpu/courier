<?php
/**
 * PHP Version 7.4.25
 * Laravel Framework 8.77.1
 *
 * @category Helper
 *
 * @package Laravel
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 *
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 06/07/22
 * */

namespace App\Helpers;

use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Helper
{
    /**
     * @param $target
     * @return string
     */
    public static function getTarget($target)
    {
        if ($target == 0) {
            return '_self';
        } else {
            return '_blank';
        }
    }

    /**
     * JSON String to php array conversion
     *
     * @param $menus
     * @return mixed
     */
    public static function convertJson($menus)
    {
//        dd(json_decode($menus, true));
        return json_decode($menus, true);
    }

    /**
     * @param string $route
     * @param int|null $route_id
     * @return string
     */
    public static function getRoute(string $route, int $route_id = null)
    {
        try {
            return route($route, $route_id);
        } catch (RouteNotFoundException $e) {
            return '';
        }
    }

    public static function getFirstRoute(string $route)
    {
        $routeArray = explode('.', $route);
        return $routeArray[0];
    }

    /**
     * Determines if select box or checkbox is selected.
     *
     * @param int|string $value The value
     * @param int|string $old The old
     * @param int|string $edit_value The edit value
     * @param string $type The type
     *
     * @return bool      True if selected, False otherwise.
     */
    public static function isSelected($value, $old, $edit_value = null, string $type = 'select')
    {
        try {
            if (!is_array($edit_value)) {
                if ($edit_value) {
                    if ($value == $edit_value) {
                        return $type == 'select' ? 'selected' : 'checked';
                    }
                } else {
                    if ($value == $old) {
                        return $type == 'select' ? 'selected' : 'checked';
                    }
                }
            } else {
                if (in_array($value, $edit_value)) {
                    return $type == 'select' ? 'selected' : 'checked';
                }
            }
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
