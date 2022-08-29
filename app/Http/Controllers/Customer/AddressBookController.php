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

namespace App\Http\Controllers\Customer;

use App\DataTables\Customer\AddressBookDataTable;
use App\Http\Controllers\Controller;
use App\Models\AddressBook;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AddressBookDataTable $dataTable
     * @return mixed
     */
    public function index(AddressBookDataTable $dataTable)
    {
        return $dataTable->render('template.customer.address_book.index_address_book');
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
        $request->has('set_as_default') ? $set_as_default = true : $set_as_default = false;
        if ($set_as_default) {
            AddressBook::where('set_as_default', true)->where('user_id', Auth::id())
                ->update(['set_as_default' => false]);
        }
        AddressBook::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name_address_book,
            'street_address' => $request->street_address_address_book,
            'street_number' => $request->street_number_address_book,
            'suburb' => $request->suburb_address_book,
            'city' => $request->city_address_book,
            'state' => $request->state_address_book,
            'zip' => $request->zip_address_book,
            'country' => $request->country_address_book,
            'place_id' => $request->place_id_address_book,
            'latitude' => $request->latitude_address_book,
            'longitude' => $request->longitude_address_book,
            'location_url' => $request->location_url_address_book,
            'full_json_response' => $request->json_response_address_book,
            'status' => $status,
            'set_as_default' => $set_as_default
        ]);
        return redirect()->route('address_book.index')->with('success', 'Address is created successfully');
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
                'company_name_address_book' => ['required'],
                'street_address_address_book' => ['required'],
                'street_number_address_book' => ['required'],
                'suburb_address_book' => ['required'],
                'city_address_book' => ['required'],
                'state_address_book' => ['required'],
                'zip_address_book' => ['required'],
                'country_address_book' => ['required'],
                'place_id_address_book' => ['required'],
                'latitude_address_book' => ['required'],
                'longitude_address_book' => ['required'],
                'location_url_address_book' => ['required'],
                'json_response_address_book' => ['required']
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AddressBook $addressBook
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, AddressBook $addressBook): RedirectResponse
    {
        $this->validator($request->all())->validate();
        $request->has('status') ? $status = true : $status = false;
        $request->has('set_as_default') ? $set_as_default = true : $set_as_default = false;
        if ($set_as_default) {
            AddressBook::where('set_as_default', true)->where('user_id', Auth::id())
                ->update(['set_as_default' => false]);
        }
        $addressBook->company_name = $request->company_name_address_book;
        $addressBook->street_address = $request->street_address_address_book;
        $addressBook->street_number = $request->street_number_address_book;
        $addressBook->suburb = $request->suburb_address_book;
        $addressBook->city = $request->city_address_book;
        $addressBook->state = $request->state_address_book;
        $addressBook->zip = $request->zip_address_book;
        $addressBook->country = $request->country_address_book;
        $addressBook->place_id = $request->place_id_address_book;
        $addressBook->latitude = $request->latitude_address_book;
        $addressBook->longitude = $request->longitude_address_book;
        $addressBook->location_url = $request->location_url_address_book;
        $addressBook->full_json_response = $request->json_response_address_book;
        $addressBook->status = $status;
        $addressBook->set_as_default = $set_as_default;
        $addressBook->save();
        if ($addressBook->wasChanged()) {
            return redirect()->route('address_book.index')->with('success', 'Address is updated successfully');
        }
        return back()->with('info', 'No changes have made.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory
     */
    public function create()
    {
        return view('template.customer.address_book.create_address_book');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AddressBook $addressBook
     * @return Application|Factory
     */
    public function edit(AddressBook $addressBook)
    {
        return view('template.customer.address_book.edit_address_book', compact('addressBook'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AddressBook $addressBook
     * @return RedirectResponse
     */
    public function destroy(AddressBook $addressBook): RedirectResponse
    {
        $addressBook->delete();
        return back()->with('success', 'Address details deleted successfully');
    }
}
