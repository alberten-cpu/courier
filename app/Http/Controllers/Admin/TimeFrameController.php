<?php

/**
 * PHP Version 7.4.25
 * Laravel Framework 8.83.18
 *
 * @category Controller
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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\getTimeframe;
use App\Models\TimeFrame;
use Illuminate\Http\JsonResponse;
use function request;

class TimeFrameController extends Controller
{
    /**
     * @return JsonResponse|void
     */
    public function getTimeframe()
    {
        if (request()->ajax()) {
            $search = request()->search;
            $id = request()->id;
            $areas = Timeframe::select('id', 'time_frame')->when(
                $search,
                function ($query) use ($search) {
                    $query->where('time_frame', 'like', '%' . $search . '%');
                }
            )->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })->limit(15)->get();
            $response = array();
            foreach ($areas as $area) {
                $response[] = array(
                    "id" => $area->id,
                    "text" => $area->time_frame
                );
            }
            return response()->json($response);
        }
    }
}
