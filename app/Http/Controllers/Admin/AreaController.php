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

use App\DataTables\Admin\AreaDataTable;
use App\Http\Controllers\Admin\User\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Area;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AreaDataTable $dataTable
     * @return Application|Factory|View|JsonResponse
     */
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('template.admin.area.index_area');
    }

    /**
     * @return JsonResponse|void
     */
    public function getAreas()
    {
        if (\request()->ajax()) {
            $search = request()->search;
            $id = request()->id;
            $areas = Area::select('id', 'area')->when(
                $search,
                function ($query) use ($search) {
                    $query->where('area', 'like', '%' . $search . '%');
                }
            )->when($id, function ($query) use ($id) {
                $query->where('id', $id);
            })->limit(15)->get();
            $response = array();
            foreach ($areas as $area) {
                $response[] = array(
                    "id" => $area->id,
                    "text" => $area->area
                );
            }
            return response()->json($response);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();
        $request->has('status') ? $status = true : $status = false;
        Area::create([
            'area' => $request->area,
            'zone_id' => $request->zone_id,
            'status' => $status,
        ]);
        return redirect()->route('area.index')->with('success', 'Area details are saved successfully');
    }

    /**
     * Validator for validate data in the request.
     *
     * @param array $data The data
     * @param int|null $id The identifier for update validation
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     **/
    protected function validator(array $data, int $id = null)
    {
        \Validator::extend(
            'without_spaces',
            function ($attr, $value) {
                return preg_match('/^\S*$/u', $value);
            }
        );

        return Validator::make(
            $data,
            [
                'area' => ['required', 'string', 'max:250'],
                'zone_id' => ['required', 'int'],

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('template.admin.area.create_area');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Area $area
     * @return Application|Factory|View
     */
    public function edit(Area $area)
    {
        return view('template.admin.area.edit_area', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Area $area
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Area $area): RedirectResponse
    {
        $this->validator($request->all(), $area->id)->validate();
        $request->has('status') ? $status = true : $status = false;
        $area->area = $request->area;
        $area->zone_id = $request->zone_id;
        $area->status = $status;
        $area->save();
        if ($area->wasChanged()) {
            return redirect()->route('area.index')->with('success', 'Area details updated successfully');
        }
        return back()->with('info', 'No changes have made.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Area $area
     * @return RedirectResponse
     */
    public function destroy(Area $area): RedirectResponse
    {
        try {
            $area->delete();
            return back()->with('success', 'Area deleted successfully');
        } catch (QueryException $e) {
            return back()->with(
                'error',
                'You Can not delete this customer due  to data integrity violation, Error:' . $e->getMessage()
            );
        }
    }
}
