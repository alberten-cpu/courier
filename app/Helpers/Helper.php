<?php
/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
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
 * Date 28/08/22
 * */

namespace App\Helpers;

use App\Models\AddressBook;
use App\Models\JobStatus;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Helper
{
    /**
     * @param $target
     * @return string
     */
    public static function getTarget($target): string
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
        return json_decode($menus, true);
    }

    /**
     * @param string $route
     * @param int|string|null $route_id
     * @return string
     */
    public static function getRoute(string $route, $route_id = null): string
    {
        try {
            return route($route, $route_id);
        } catch (RouteNotFoundException $e) {
            return '';
        }
    }

    /**
     * @param string $route
     * @return mixed|string
     */
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

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getAddressBook($user_id)
    {
        return AddressBook::where('user_id', $user_id)->get();
    }

    /**
     * @return mixed
     */
    public static function getJobStatus()
    {
        return JobStatus::pluck('status', 'id')->toArray();
    }

    /**
     * @param $string
     * @return bool
     */
    public static function isJson($string): bool
    {
        return is_string($string) && is_array(json_decode($string, true));
    }
}
