<?php

namespace App\Services;

use App\Models\ContactInquiry;
use Illuminate\Support\Facades\Validator;

class ContactService
{
    public function store(array $data): ContactInquiry
    {
        $validated = Validator::make($data, [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
            'type'    => 'nullable|string|max:50',
        ])->validate();

        return ContactInquiry::create($validated);
    }
}
