<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Auth;
class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:enquiry-list', ['only' => ['index']]);
        $this->middleware('permission:enquiry-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:enquiry-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:enquiry-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $enquiries = Enquiry::with('user')->get();
        return view('admin.enquiries.index', compact('enquiries'));
    }

    // Show form to create an enquiry
    public function create()
    {
        return view('admin.enquiries.create');
    }

    // Store a new enquiry
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email',
            'query' => 'required|string',
            // 'mobile' => 'required|numeric|digits:10',
        ]);
        $inputs     =   $request->all();
        $user       =   User::find(Auth::user()->id);
        $inputs['user_id']  =   Auth::user()->id;
        $inputs['name']     =   $user->name;
        $inputs['email']    =   $user->email;
        $inputs['mobile']   =   $user->mobile;
        Enquiry::create($inputs);

        return redirect()->route('enquiries.create')->with('success', 'Enquiry created successfully.');
    }

    // Show a single enquiry
    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    // Show form to edit an enquiry
    public function edit(Enquiry $enquiry)
    {
        return view('admin.enquiries.edit', compact('enquiry'));
    }

    // Update an existing enquiry
    public function update(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:10',
            'query' => 'required|string',
        ]);

        $enquiry->update($request->all());

        return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');
    }

    // Delete an enquiry
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}

