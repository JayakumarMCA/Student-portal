<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Industry;
use App\Models\Product;
use App\Models\AssetType;
use App\Models\AssetUtilization;
use App\Models\Language;
use App\Models\Country;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:asset-list', ['only' => ['index']]);
        $this->middleware('permission:asset-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query          =   Asset::with(['industry', 'product', 'assetType', 'utilization', 'language', 'country']);
        if (isset($request->search)) {
            if ($request->title) {
                $title = $request->title;
                $title = trim($request->title, '"');
                $query->where('assets.title', 'like', '%' . $title . '%');
            }
            if ($request->product_id) {
                $product_id = $request->product_id;
                $query->where('assets.product_id',$product_id);
            }
            if ($request->industry_id) {
                $industry_id = $request->industry_id;
                $query->where('assets.industry_id',$industry_id);
            }
            if ($request->asset_type_id) {
                $asset_type_id = $request->asset_type_id;
                $query->where('assets.asset_type_id',$asset_type_id);
            }
            if ($request->utilization_id) {
                $utilization_id = $request->utilization_id;
                $query->where('assets.utilization_id',$utilization_id);
            }
            if ($request->language_id) {
                $language_id = $request->language_id;
                $query->where('assets.language_id',$language_id);
            }
            if ($request->country_id) {
                $country_id = $request->country_id;
                $query->where('assets.country_id',$country_id);
            }
        }
        $industries     =   Industry::all();
        $products       =   Product::all();
        $assetTypes     =   AssetType::all();
        $utilizations   =   AssetUtilization::all();
        $languages      =   Language::all();
        $countries      =   Country::all();
        $assets         =   $query->get();
        return view('admin.assets.index', compact('request','assets','industries','products','assetTypes','utilizations','languages','countries'));
    }

    public function create()
    {
        return view('admin.assets.create', [
            'industries' => Industry::all(),
            'products' => Product::all(),
            'assetTypes' => AssetType::all(),
            'utilizations' => AssetUtilization::all(),
            'languages' => Language::all(),
            'countries' => Country::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'industry_id' => 'required|integer|exists:industries,id',
            'other_industry' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->industry_id == 4 && empty($value)) {
                        $fail("The Other Industry field is required when selecting 'Other'.");
                    }
                }
            ],
            'product_id' => 'required|integer|exists:products,id',
            'asset_type_id' => 'required|integer|exists:asset_types,id',
            'utilization_id' => 'required|integer|exists:asset_utilizations,id',
            'language_id' => 'required|integer|exists:languages,id',
            'country_id' => 'required|integer|exists:countries,id',
            'file' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $assetType = AssetType::find($request->asset_type_id);
                    if ($assetType) {
                        $allowedExtensions = explode(',', $assetType->type);
                        if (!in_array($value->getClientOriginalExtension(), $allowedExtensions)) {
                            $fail("The file must be one of the following types: " . implode(',', $allowedExtensions));
                        }
                    }
                }
            ],
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/assets', $fileName, 'public');
        }

        Asset::create([
            'title' => $request->title,
            'industry_id' => $request->industry_id,
            'other_industry' => $request->other_industry,
            'product_id' => $request->product_id,
            'asset_type_id' => $request->asset_type_id,
            'utilization_id' => $request->utilization_id,
            'language_id' => $request->language_id,
            'country_id' => $request->country_id,
            'file' => $filePath ?? null,
        ]);

        return redirect()->route('assetdatas.index')->with('success', 'Asset created successfully.');
    }
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $industries = Industry::all();
        $products = Product::all();
        $assetTypes = AssetType::all();
        $utilizations = AssetUtilization::all();
        $languages = Language::all();
        $countries = Country::all();

        return view('admin.assets.edit', compact(
            'asset', 'industries', 'products', 'assetTypes', 'utilizations', 'languages', 'countries'
        ));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'industry_id' => 'required|integer|exists:industries,id',
            'other_industry' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->industry_id == 4 && empty($value)) {
                        $fail("The Other Industry field is required when selecting 'Other'.");
                    }
                }
            ],
            'product_id' => 'required|integer|exists:products,id',
            'asset_type_id' => 'required|integer|exists:asset_types,id',
            'utilization_id' => 'required|integer|exists:asset_utilizations,id',
            'language_id' => 'required|integer|exists:languages,id',
            'country_id' => 'required|integer|exists:countries,id',
            'file' => [
                'nullable', // Make it optional for updates
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->hasFile('file')) {
                        $assetType = AssetType::find($request->asset_type_id);
                        if ($assetType) {
                            $allowedExtensions = explode(',', $assetType->type);
                            if (!in_array($value->getClientOriginalExtension(), $allowedExtensions)) {
                                $fail("The file must be one of the following types: " . implode(',', $allowedExtensions));
                            }
                        }
                    }
                }
            ],
        ]);
    
        $asset = Asset::findOrFail($id);
        $asset->title = $request->title;
        $asset->industry_id = $request->industry_id;
        $asset->product_id = $request->product_id;
        $asset->asset_type_id = $request->asset_type_id;
        $asset->utilization_id = $request->utilization_id;
        $asset->language_id = $request->language_id;
        $asset->country_id = $request->country_id;
        $asset->other_industry = $request->other_industry ?? null;
    
        if ($request->hasFile('file')) {
            if ($asset->file) {
                Storage::delete('public/' . $asset->file);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/assets', $fileName, 'public');
            $asset->file = $filePath;
        }
    
        $asset->save();
    
        return redirect()->route('assetdatas.index')->with('success', 'Asset updated successfully.');
    }
}
