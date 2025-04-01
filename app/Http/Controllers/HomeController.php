<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Country;
use App\Models\Language;
use App\Models\Product;
use App\Models\AssetType;
use App\Models\AssetUtilization;
use App\Models\Asset;
use App\Models\Industry;
use App\Models\UsageLog;
use App\Mail\AssetEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;
use ZipStream\OperationMode;
use Illuminate\Support\Facades\Storage;

// use ZipArchive;

class HomeController extends Controller
{
    public function getEvent()
    {
        // Fetch data from tables
        $countries          =   Country::pluck('name', 'id');
        $languages          =   Language::pluck('name', 'id');
        $events             =   Event::with('country','language')->paginate(15);

        return view('admin.event', compact('countries', 'events','languages'));
    }
    public function getFetchEventsold(Request $request)
    {
        $query = Event::with('country','language')->query();

        // Apply filters
        if ($request->has('languages')) {
            $query->whereIn('language_id', $request->languages);
        }

        if ($request->has('countries')) {
            $query->whereIn('country_id', $request->countries);
        }

        if ($request->has('products')) {
            $query->whereIn('product_id', $request->products);
        }

        if ($request->has('assetTypes')) {
            $query->whereIn('asset_type_id', $request->assetTypes);
        }

        if ($request->has('assetUtilizations')) {
            $query->whereIn('utilization_id', $request->assetUtilizations);
        }

        // Apply sorting
        if ($request->has('sort_by')) {
            if ($request->sort_by == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort_by == 'name_desc') {
                $query->orderBy('name', 'desc');
            } else {
                $query->orderBy('date', 'desc');
            }
        }

        // Pagination
        $events = $query->paginate(15);

        return response()->json($events);
    }
    public function getFetchEventsOLDs(Request $request)
    {
        $query = Event::with('country', 'language');
        // Apply filters
        if ($request->filled('languages')) {
            $query->whereIn('language_id', $request->languages);
        }

        if ($request->filled('countries')) {
            $query->whereIn('country_id', $request->countries);
        }
        // Apply sorting
        dd($request->languages);
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('date', 'desc');
                    break;
            }
        } else {
            // Default sorting by latest event date
            $query->orderBy('date', 'desc');
        }
        dd("hi");
        // Pagination
        $events = $query->paginate(15);
        return response()->json([
            'data' => $events->items(),
            'current_page' => $events->currentPage(),
            'last_page' => $events->lastPage(),
            'total' => $events->total(),
            'from' => $events->firstItem(),
            'to' => $events->lastItem(),
            'pagination' => (string) $events->links(), // Send pagination as HTML
        ]);
    }
    public function getFetchEvents(Request $request)
    {
        $query = Event::with('country', 'language');
        $languages = $request->filled('languages') ? (array) json_decode($request->languages, true) : [];
        $countries = $request->filled('countries') ? (array) json_decode($request->countries, true) : [];

        if (!empty($languages)) {
            $query->whereIn('language_id', $languages);
        }

        if (!empty($countries)) {
            $query->whereIn('country_id', $countries);
        }
        if (!empty($request->search_query)) {
            $query->where('title', 'like', '%' . $request->search_query . '%');
        }

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'name_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->orderBy('date', 'desc');
                    break;
            }
        } else {
            $query->orderBy('date', 'desc');
        }
        $events = $query->paginate(15);
        $paginationHtml = $events->appends($request->query())->links()->toHtml();
        return response()->json([
            'data' => $events->items(),
            'current_page' => $events->currentPage(),
            'last_page' => $events->lastPage(),
            'total' => $events->total(),
            'from' => $events->firstItem(),
            'to' => $events->lastItem(),
            'pagination' => $paginationHtml,
        ]);
    }
    public function getAssetDetails(Request $request)
    {
        // Start query with eager loading
        $query = Asset::with(['industry', 'product', 'assetType', 'utilization', 'language', 'country']);
    
        // Apply filters
        if ($request->filled('industry')) {
            $query->whereIn('industry_id', (array) $request->industry);
        }
        if ($request->filled('product')) {
            $query->whereIn('product_id', (array) $request->product);
        }
        if ($request->filled('asset_type')) {
            $query->whereIn('asset_type_id', (array) $request->asset_type);
        }
        if ($request->filled('utilization')) {
            $query->whereIn('utilization_id', (array) $request->utilization);
        }
        if ($request->filled('language')) {
            $query->where('language_id', $request->language);
        }
        if ($request->filled('country')) {
            $query->where('country_id', $request->country);
        }
        if (!empty($request->search_query)) {
            $query->where('title', 'like', '%' . $request->search_query . '%');
        }
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'date':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }
        $assets = $query->paginate(10);
        return response()->json([
            'data' => $assets->items(),
            'pagination' => $assets->links()->toHtml(),
        ]);
    }
      
    public function getAssetLists()
    {
        $assets = Asset::with(['industry', 'product', 'assetType', 'utilization', 'language', 'country'])->get();
        $industries = Industry::all();
        $products = Product::all();
        $assetTypes = AssetType::all();
        $utilizations = AssetUtilization::all();
        $languages = Language::all();
        $countries = Country::all();
        return view('admin.page',compact('assets','industries','products','assetTypes','utilizations','languages','countries'));
    }
    
    public function bulkDownload(Request $request)
    {
        $assetIds = $request->asset_ids;
        if (!$assetIds || count($assetIds) === 0) {
            return response()->json(['error' => 'No assets selected'], 400);
        }
        $assets = Asset::whereIn('id', $assetIds)->get();
        if ($assets->isEmpty()) {
            return response()->json(['error' => 'No valid files found'], 400);
        }
        $response = new StreamedResponse(function () use ($assets) {
            $zip = new ZipStream(outputName: 'assets.zip', operationMode: OperationMode::NORMAL);
            foreach ($assets as $asset) {
                UsageLog::create([
                    'user_id'=>Auth::user()->id,
                    'type'=>1,
                    'type_id'=>$asset->id,
                    'download_type'=>"download",
                ]);
                $filePath = storage_path("app/public/{$asset->file}");
                if (file_exists($filePath)) {
                    $zip->addFileFromPath(basename($filePath), $filePath);
                }
            }
            $zip->finish();
        });
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="assets.zip"');
        return $response;
    }
    public function fetchDownloadAsset(Request $request)
    {
        $asset_id = $request->asset_id;
        $asset = Asset::find($asset_id);

        if (!$asset) {
            return response()->json(['error' => 'Asset not found'], 404);
        }
        UsageLog::create([
            'user_id'=>Auth::user()->id,
            'type'=>1,
            'type_id'=>$asset->id,
            'download_type'=>"download",
        ]);
        $filePath = storage_path("app/public/{$asset->file}");

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }
    public function storeEventLog(Request $request)
    {
        $log = UsageLog::create([
            'user_id' => $request->user_id,
            'type' => 2,
            'type_id' => $request->type_id,
            'download_type'=>"click",
        ]);

        return response()->json(['message' => 'Usage log saved', 'data' => $log]);
    }
    public function sendAssetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'asset_ids' => 'required|array|min:1|max:10', // Limit the number of assets to 10
            'asset_ids.*' => 'required|exists:assets,id',
        ]);
        $filePaths = Asset::whereIn('id', $request->asset_ids)
            ->pluck('file')
            ->map(function ($file) {
                return storage_path('app/public/' . $file); // Use 'public/' for public disk
            })
            ->filter(function ($filePath) {
                return file_exists($filePath); // Ensure the file exists
            })
            ->toArray();
        if (empty($filePaths)) {
            return response()->json(['message' => 'No valid files found for attachment'], 400);
        }

        try {
            Mail::to($request->email)->send(new AssetEmail($filePaths));

            return response()->json(['message' => 'Email sent successfully with attachments']);
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to send email. Please try again later.'], 500);
        }
    }

    public function getDashboard(Request $request)
    {
        $getUser     =   User::count();
        $getAsset    =   Asset::count();
        $getEvent    =   Event::count();
        return view('admin.dashboard',compact('getUser','getAsset','getEvent'));
    }
}

