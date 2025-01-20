<?php
namespace App\Http\Controllers;

use App\Services\AddressService;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $addresses = $this->addressService->getUserAddresses();

        return view('address.index', compact('addresses'));
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(AddressRequest $request)
    {
        $this->addressService->createAddress($request->validated());

        return redirect()->route('address.index')->with('success', 'Address added successfully!');
    }

    public function edit($id)
    {
        $address = $this->addressService->getUserAddresses()->find($id);

        if (!$address) {
            abort(404, 'Address not found.');
        }

        return view('address.edit', compact('address'));
    }

    public function update(AddressRequest $request, $id)
    {
        $this->addressService->updateAddress($id, $request->validated());

        return redirect()->route('address.index')->with('success', 'Address updated successfully!');
    }
}
