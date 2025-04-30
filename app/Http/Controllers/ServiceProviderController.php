<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;



class ServiceProviderController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceProvider::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $providers = $query->paginate(12)->withQueryString();

        return Inertia::render('Index', [
            'serviceProviders' => $providers,
            'filters' => $request->only('category_id'),
        ]);
    }

    public function show(ServiceProvider $provider)
    {
        $provider->load('category');

        return Inertia::render('Show', [
            'provider' => $provider,
        ]);
    }
}
