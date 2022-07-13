<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AreaDataTable;
use App\Http\Controllers\Admin\User\CustomerDataTable;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Area;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CustomerDataTable $dataTable
     * @return Application|Factory|View|JsonResponse
     */
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('template.admin.user.area.index_area');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.admin.user.area.create_area');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->has('status') ? $status = true : $status = false;
        $user = Area::create([

            'area' => $request->area,
            'zone_id' => $request->zone_id,
            'status' => $status,
        ]);
        return back()->with('success', 'Area details are saved successfully');
    }

    /**
     * Validator for validate data in the request.
     *
     * @param array $data The data
     * @param int|null $id The identifier for update validation
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     **/
    protected function validator(array $data, int $id = null )
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('template.admin.user.area.edit_area', compact('area'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $this->validator($request->all(), $area->id)->validate();
        $request->has('status') ? $status = true : $status = false;
        $area->area = $request->area;
        $area->zone_id = $request->zone_id;
        $area->status = $status;
        if (!$area->isDirty()) {
            return back()->with('info', 'No changes have made.');
        }
        $area->save();
        return back()->with('success', 'Area details updated successfully');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
