<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\CountryStoreRequest;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::all();
        if ($request->has('search')) {
            $countries = Country::where('country_code', 'like', "%{$request->search}%")->orWhere('name', 'like', "%{$request->search}%")->get();
        }
        return view('countries.index', compact('countries'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(CountryStoreRequest $request)
    {
        Country::create($request->validated());
        return redirect()->route('countries.index')->with('message', 'Country Created Succesfully');
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(CountryStoreRequest $request, Country $country)
    {
        $country->update($request->validated());
        return redirect()->route('countries.index')->with('message', 'Country Updated Succesfully');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('message', 'Country Deleted Succesfully');
    }
}
