<?php

// app/Http/Controllers/ServiceProviderController.php
namespace App\Http\Controllers;
use App\ServiceProviderModel as ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function index()
    {
        $providers = ServiceProvider::all();
        return view('service_providers.index', compact('providers'));
    }

    public function create()
    {
        return view('service_providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'phone' => 'required|string|max:12|unique:service_providers,phone',
        'address' => 'nullable|string|max:255',
        ]);

        ServiceProvider::create($request->all());

        return redirect()->route('service-providers.index')->with('success', 'Service Provider created successfully.');
    }

    public function edit(ServiceProvider $serviceProvider)
    {
        return view('service_providers.edit', compact('serviceProvider'));
    }

    public function update(Request $request, ServiceProvider $serviceProvider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $serviceProvider->update($request->all());

        return redirect()->route('service-providers.index')->with('success', 'Updated successfully.');
    }

    public function destroy(ServiceProvider $serviceProvider)
    {
        $serviceProvider->delete();
        return redirect()->route('service-providers.index')->with('success', 'Deleted successfully.');
    }
}
