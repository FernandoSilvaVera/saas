<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactPostRequest;
use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactPostRequest $request)
    {
        $data = $request->all();

        $contact = Contact::create($data);

        Mail::to(config('consts.contacts.email'))
            ->send(new ContactNotification($contact));

        return response()->json([], 201);
    }
}
