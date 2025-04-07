<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'mobile' => 'required|digits:10',
    //         'password' => [
    //             'required',
    //             'min:8',               // Minimum 8 characters
    //             'regex:/[A-Z]/',       // At least one uppercase letter
    //             'regex:/[a-z]/',       // At least one lowercase letter
    //             'regex:/[0-9]/',       // At least one digit
    //             'regex:/[@$!%*?&]/',   // At least one special character
    //             'confirmed'            // Password confirmation (add password_confirmation field in the form)
    //         ],
    //         'organization' => 'required|string|max:255',
    //         'job_title' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'country' => 'required|string',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }
    
    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'mobile' => $request->mobile,
    //         'password' => Hash::make($request->password),
    //         'organization' => $request->organization,
    //         'job_title' => $request->job_title,
    //         'city' => $request->city,
    //         'country' => $request->country,
    //     ]);
    
    //     return redirect()->route('login')->with('success', 'Registration successful!');
    // }
    public function register(Request $request)
    {
        // Validate form fields
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
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
        $plainPassword = generateStrongPassword(14);
        $hashedPassword = Hash::make($plainPassword);
        $student = Student::create([
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
            'doc' => $docPaths,
            'address' => $request->address,
            'password' => $hashedPassword,
            'user_type' => 2,
            'status' => 1,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
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
}
