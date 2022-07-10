<?php

namespace App\Http\Controllers\Admin\User;

use App\DataTables\User\DriverDataTable;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(DriverDataTable $dataTable)
    {
        return $dataTable->render('template.admin.user.driver.index_driver');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->has('is_active') ? $is_active = true : $is_active = false;
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make('driver@123'),
            'role_id' => Role::DRIVER,
            'is_active' => $is_active,
        ]);
        $driver = Driver::create([
            'user_id' => $user->id,
        ]);
        $driver->driver_id = $driver->createIncrementDriverId($driver->id);
        $driver->save();
        return back()->with('success', 'Driver details is saved successfully');
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
                'first_name' => ['required', 'string', 'max:250'],
                'last_name' => ['required', 'string'],
                'email' => ['required', 'string', 'unique:users,email,' . $id],
                'mobile' => ['required', 'unique:users,mobile,' . $id],
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
        return view('template.admin.user.driver.create_driver');
    }

    /**
     * Display the specified resource.
     *
     * @param User $driver
     * @return Response
     */
    public function show(User $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $driver
     * @return Application|Factory|View
     */
    public function edit(User $driver)
    {
        return view('template.admin.user.driver.edit_driver', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $driver
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $driver): RedirectResponse
    {
        $this->validator($request->all(), $driver->id)->validate();
        $request->has('is_active') ? $is_active = true : $is_active = false;
        $driver->name = $request->first_name . ' ' . $request->last_name;
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->email = $request->email;
        $driver->mobile = $request->mobile;
        $driver->is_active = $is_active;
        if (!$driver->isDirty()) {
            return back()->with('info', 'No changes have made.');
        }
        $driver->save();
        return back()->with('success', 'Driver details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $driver
     * @return RedirectResponse
     */
    public function destroy(User $driver): RedirectResponse
    {
        $driver->delete();
        return back()->with('success', 'Driver details deleted successfully');
    }
}
