<?php

namespace App\Http\Controllers\Admin\User;

use App\DataTables\User\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Role;
use App\Models\User;
use DataTables;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CustomerDataTable $dataTable
     * @return Application|Factory|View|JsonResponse
     */
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('template.admin.user.customer.index_customer');
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
        $request->has('is_active') ? $is_active = true : $is_active = false;
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'role_id' => Role::CUSTOMER,
            'is_active' => $is_active,
        ]);
        $customer = Customer::create([
            'user_id' => $user->id,
        ]);
        $customer->customer_id = $customer->createIncrementCustomerId($customer->id);
        $customer->save();
        return back()->with('success', 'Customer details is saved successfully');
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
     * Show the form for creatidashboardng a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('template.admin.user.customer.create_customer');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $customer
     * @return Application|Factory|View
     */
    public function edit(User $customer)
    {
        return view('template.admin.user.customer.edit_customer', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $customer
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $customer): RedirectResponse
    {
        $this->validator($request->all(), $customer->id)->validate();
        $request->has('is_active') ? $is_active = true : $is_active = false;
        $customer->name = $request->first_name . ' ' . $request->last_name;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->is_active = $is_active;
        if (!$customer->isDirty()) {
            return back()->with('info', 'No changes have made.');
        }
        $customer->save();
        return back()->with('success', 'Customer details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $customer
     * @return RedirectResponse
     */
    public function destroy(User $customer): RedirectResponse
    {
        $customer->delete();
        return back()->with('success', 'Customer details deleted successfully');
    }
}
