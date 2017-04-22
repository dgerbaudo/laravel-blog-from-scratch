<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationForm;


class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store(RegistrationForm $request)
    {

        return redirect()->home();

    }
}
