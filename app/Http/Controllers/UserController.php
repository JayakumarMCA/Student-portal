<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CourseMaster;
use App\Models\Batch;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $query = User::with(['role']);
        if (isset($request->search)) {
            if ($request->name) {
                $name = $request->name;
                $name = trim($request->name, '"');
                $query->where('users.name', 'like', '%' . $name . '%');
            }
            if ($request->email) {
                $email = $request->email;
                $query->where('users.email',$email);
            }
            if ($request->mobile) {
                $mobile = $request->mobile;
                $query->where('users.mobile',$mobile);
            }
        }
        $roles      =   Role::all();
        $users      =   $query->get();
        return view('admin.users.index', compact('request','users','roles'));
    }
    public function create()
    {
        $courses = CourseMaster::pluck('title', 'id');
        return view('admin.users.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits_between:8,15',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'dob' => 'required|date',
            'graduate' => 'required|in:1,2',
            'year_of_passing' => 'required|string|max:10',
            'whatsapp_num' => 'required|in:1,2',
            'course_id' => 'required|exists:course_masters,id',
            'batch_id' => 'required|exists:batches,id',
            'nri' => 'required|in:1,2',
            'photo_copy' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_proof_photo_copy' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_photo_copy' => 'required_if:nri,1|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'address' => 'required|string|max:1000',
        ]);

        // If NRI, passport is required
        if ($request->nri == 1 && !$request->hasFile('passport_photo_copy')) {
            return back()->withErrors(['passport_photo_copy' => 'Passport photo copy is required for NRI'])->withInput();
        }

        // Handle file uploads
        $photoCopyPath = $request->file('photo_copy')->storeAs(
            'students/photo_copy',
            'photo_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('photo_copy')->getClientOriginalExtension(),
            'public'
        );
        
        $idProofPath = $request->file('id_proof_photo_copy')->storeAs(
            'students/id_proof',
            'idproof_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('id_proof_photo_copy')->getClientOriginalExtension(),
            'public'
        );
        $docPath = $request->file('doc')->storeAs(
            'students/documents',
            'doc_' . date('Ymd_His') . '_' . \Str::random(6) . '.' . $request->file('doc')->getClientOriginalExtension(),
            'public'
        );
        $passportPath = $request->hasFile('passport_photo_copy')
            ? $request->file('passport_photo_copy')->storeAs(
                'students/passport',
                'passport_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('passport_photo_copy')->getClientOriginalExtension(),
                'public'
            )
            : null;
        // Save student
        $plainPassword = HomeController::generateStrongPassword(14);
        $hashedPassword = Hash::make($plainPassword);
        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'graduate' => $request->graduate,
            'year_of_passing' => $request->year_of_passing,
            'whatsapp_num' => $request->whatsapp_num,
            'course_id' => $request->course_id,
            'batch_id' => $request->batch_id,
            'nri' => $request->nri,
            'photo_copy' => $photoCopyPath,
            'id_proof_photo_copy' => $idProofPath,
            'passport_photo_copy' => $passportPath,
            'doc' => $docPath,
            'address' => $request->address,
            'password' => $hashedPassword,
            'user_type' => 2,
            'status' => 1,
            'role_id'=>3
        ]);
    
        // Attach roles to the user
        $user->roles()->attach(3);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles   = Role::all();
        $courses = CourseMaster::pluck('title', 'id');
        $batches = Batch::pluck('name','id');
        return view('admin.users.edit', compact('user', 'courses', 'roles','batches'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|digits_between:8,15',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'dob' => 'required|date',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required',
            'graduate' => 'required|in:1,2',
            'year_of_passing' => 'required|string|max:10',
            'whatsapp_num' => 'required|in:1,2',
            'course_id' => 'required|exists:course_masters,id',
            'batch_id' => 'required|exists:batches,id',
            'nri' => 'required|in:1,2',
            'photo_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_proof_photo_copy' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'passport_photo_copy' => 'required_if:nri,1|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'address' => 'required|string|max:1000',
        ]);

        // Handle file uploads if present
        if ($request->hasFile('photo_copy')) {
            $photoCopyPath = $request->file('photo_copy')->storeAs(
                'students/photo_copy',
                'photo_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('photo_copy')->getClientOriginalExtension(),
                'public'
            );
            $user->photo_copy = $photoCopyPath;
        }

        if ($request->hasFile('id_proof_photo_copy')) {
            $idProofPath = $request->file('id_proof_photo_copy')->storeAs(
                'students/id_proof',
                'idproof_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('id_proof_photo_copy')->getClientOriginalExtension(),
                'public'
            );
            $user->id_proof_photo_copy = $idProofPath;
        }

        if ($request->hasFile('doc')) {
            $docPath = $request->file('doc')->storeAs(
                'students/documents',
                'doc_' . date('Ymd_His') . '_' . Str::random(6) . '.' . $request->file('doc')->getClientOriginalExtension(),
                'public'
            );
            $user->doc = $docPath;
        }

        if ($request->hasFile('passport_photo_copy')) {
            $passportPath = $request->file('passport_photo_copy')->storeAs(
                'students/passport',
                'passport_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $request->file('passport_photo_copy')->getClientOriginalExtension(),
                'public'
            );
            $user->passport_photo_copy = $passportPath;
        }

        // Update fields
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob,
            'graduate' => $request->graduate,
            'year_of_passing' => $request->year_of_passing,
            'whatsapp_num' => $request->whatsapp_num,
            'course_id' => $request->course_id,
            'batch_id' => $request->batch_id,
            'nri' => $request->nri,
            'address' => $request->address,
            'status' => $request->status,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}

