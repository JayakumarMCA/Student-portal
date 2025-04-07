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
use App\Models\CourseMaster;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipStream\ZipStream;
use ZipStream\OperationMode;
use Illuminate\Support\Facades\Storage;

// use ZipArchive;

class HomeController extends Controller
{
    public function getDashboard(Request $request)
    {
        $getUser     =   User::count();
        $getAsset    =   Asset::count();
        $getEvent    =   Event::count();
        return view('admin.dashboard',compact('getUser','getAsset','getEvent'));
    }
    public function register(Request $request)
    {
        $courses = CourseMaster::pluck('title', 'id');
        return view('auth.register',compact('courses'));
    }
    public function getBatches($course_id)
    {
        $batches = \App\Models\Batch::where('course_id', $course_id)->pluck('name', 'id');
        return response()->json($batches);
    }
    public function storeRegister(Request $request)
    {
        // Validate form fields
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

        return redirect()->back()->with('success', 'Registration successful!');
    }
    function generateStrongPassword($length = 12) {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_+-={}[]|:;<>,.?';
    
        $all = $upper . $lower . $numbers . $symbols;
        $password = $upper[rand(0, strlen($upper)-1)] .
                    $lower[rand(0, strlen($lower)-1)] .
                    $numbers[rand(0, strlen($numbers)-1)] .
                    $symbols[rand(0, strlen($symbols)-1)];
    
        for ($i = 4; $i < $length; $i++) {
            $password .= $all[rand(0, strlen($all)-1)];
        }
    
        return str_shuffle($password);
    }
    public function profile()
    {
        $user = auth()->user();
        $courses = CourseMaster::all();
        return view('admin.users.profile', compact('user','courses'));
    }
    public function changePassword()
    {
        return view('admin.users.change-password'); // Show change password form
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/|confirmed',
            'old_password' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Incorrect current password']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ]);
        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        // Redirect with success message
        return back()->with('success', 'Profile updated successfully.');
    }
}

