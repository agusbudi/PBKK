<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class FormController extends Controller
{
    public function index()
    {
        return view('form');
    }

    public function show(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'name' => 'required|alpha:ascii',
            'float' => 'required|numeric|between:2.50,99.99',
            'image' => 'required|max:2048|mimes:jpg,jpeg,png'
        ]);

        $filename = time() . '_' . $request->image->getClientOriginalName();

        $request->image->storeAs('public/images', $filename);

        $results = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'float' => $request->float,
            'image' => $filename,
        ];

        Form::create($results);

        return redirect()->back()->with(['status' => 'Form submitted!']);
    }

    public function result(String $name)
    {
        $form = Form::where('name', $name)->first();
        $results = [
            'email' => $form->email,
            'name' => $form->name,
            'float' => $form->float,
            'image' => $form->image
        ];  

        return view('result', [
            'results' => $results
        ]);
    }
}
