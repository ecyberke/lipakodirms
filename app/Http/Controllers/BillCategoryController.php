<?php

// app/Http/Controllers/BillCategoryController.php
namespace App\Http\Controllers;
use App\BillCategory;
use Illuminate\Http\Request;

class BillCategoryController extends Controller
{
    public function index()
    {
        $providers = BillCategory::all();
        return view('billscategories.index', compact('providers'));
    }

    public function create()
    {
        return view('billscategories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'category_name' => 'required|string|max:255',
        'type' => 'nullable',
        ]);

        BillCategory::create($request->all());

        return redirect()->route('billscategories.index')->with('success', 'Bill Category created successfully.');
    }

    public function edit(BillCategory $BillCategory)
    
    {
        $BillCategory = BillCategory::where('id', $BillCategory )->first();
        return view('billscategories.edit', compact('BillCategory'));
    }

    public function update(Request $request, BillCategory $BillCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $BillCategory->update($request->all());

        return redirect()->route('billscategories.index')->with('success', 'Bill Category Updated successfully.');
    }

    public function destroy(BillCategory $BillCategory)
    {
        $BillCategory->delete();
        return redirect()->route('billscategories.index')->with('success', 'Bill Category Deleted successfully.');
    }
}
