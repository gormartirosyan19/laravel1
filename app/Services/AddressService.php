<?php

namespace App\Services;

use App\Models\Address;
use Illuminate\Support\Facades\{Auth, DB};

class AddressService
{
    public function getUserAddresses()
    {
        return Address::where('user_id', Auth::id())->get();
    }

    public function createAddress($data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['is_default']) && $data['is_default']) {
                $this->unsetDefaultAddress();
            }

            return Address::create(array_merge($data, ['user_id' => Auth::id()]));
        });
    }

    public function updateAddress($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $address = Address::where('user_id', Auth::id())->findOrFail($id);

            if (isset($data['is_default']) && $data['is_default']) {
                $this->unsetDefaultAddress($id);
            }

            $address->update($data);

            return $address;
        });
    }

    private function unsetDefaultAddress($excludeId = null)
    {
        Address::where('user_id', Auth::id())
            ->when($excludeId, function ($query, $excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->update(['is_default' => false]);
    }
}
