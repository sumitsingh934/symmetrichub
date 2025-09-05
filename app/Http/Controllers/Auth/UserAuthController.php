<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Plan;
use App\Models\Discount;
use App\Models\Course;
use App\Models\CoursePrice;
use App\Mail\UserConfirmationMail;
use Carbon\Carbon;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {

        if ($user->status == 1) {
            Auth::guard('web')->login($user);
            return redirect()->route('user_dashboard');
        } else {
            return back()->withErrors(['email' => 'Your account is not active please contact our team.']);
        }
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

//     public function register()
//    {
//     $courses = Course::with('course_price')->get();

//     //echo '<pre>'; print_r($courses->toArray()); die;

//     return view('auth.user.register', compact('courses'));
//    }

public function register()
{
    $courses = Course::with('course_price')->get()->map(function ($course) {
        $prices = $course->course_price->mapWithKeys(function ($price) {
            return [$price->duration => $price->price];
        })->toArray();

        return [
            'id' => $course->id,
            'name' => $course->name,
            'durations' => $course->course_price->pluck('duration')->unique()->values()->all(),
            'prices' => $prices,
        ];
    });

$discount = Discount::latest()->first();

if ($discount) {

    $discountDate = Carbon::parse($discount->discount_date)->startOfDay();


    $expiryDate = $discountDate->copy()->addDays($discount->discount_duration_day)->startOfDay();

    $isDiscountActive = Carbon::now()->lt($expiryDate);
} else {
    $isDiscountActive = false;
}

    return view('auth.user.register', compact('courses','isDiscountActive','discount'));
}



    public function showReferral($ref)
   {

    $user = $ref;

    $courses = Course::with('course_price')->get()->map(function ($course) {
        $prices = $course->course_price->mapWithKeys(function ($price) {
            return [$price->duration => $price->price];
        })->toArray();

        return [
            'id' => $course->id,
            'name' => $course->name,
            'durations' => $course->course_price->pluck('duration')->unique()->values()->all(),
            'prices' => $prices,
        ];
    });

$discount = Discount::latest()->first();

if ($discount) {

    $discountDate = Carbon::parse($discount->discount_date)->startOfDay();


    $expiryDate = $discountDate->copy()->addDays($discount->discount_duration_day)->startOfDay();

    $isDiscountActive = Carbon::now()->lt($expiryDate);
} else {
    $isDiscountActive = false;
}

    
    return view('auth.user.user-register', compact('user','courses','isDiscountActive','discount'));
   }


public function store(Request $request)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => ['required', 'digits:10'],
        'course' => 'required|string|max:255',
        'duration' => 'required|string|max:255',
        'password' => 'required|string|min:8',
        'gender' => 'required',
        'price' => 'required|numeric',
    ]);


    $code = $request->input('coupon');

    $discount = Discount::where('coupon_number', $code)
        ->where('status', 1)
        ->first();

    if ($discount) {

        $existingUse = User::where('discount_id', $discount->id)->where('email', $request->email)->exists();

        if ($existingUse) {
            return back()->withErrors(['coupon' => 'This coupon has already been used.']);
        }
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'wallet' => 0,
        'gender' => $request->gender,
        'discount_id' => $discount->id ?? 0
    ]);

    $user->referral_id = strtoupper(Str::random(6)) . '-' . $user->id;
    $user->save();

    Plan::create([
        'course_id' => $request->course,
        'valid' => $request->duration,
        'referred_by' => $request->referred_by ?? 'self',
        'user_id' => $user->id,
        'amount' => $request->price
    ]);

    if (!empty($user->email)) {
        Mail::to($user->email)->send(new UserConfirmationMail($user));
    }

    return redirect()->route('login');
}


    public function user_dashboard(){
        
        $user = Auth()->user();
    
        $plan = Plan::where('user_id',$user->id)->get();
        $total_amount = 0;
        foreach ($plan as $plans) {
            $total_amount += $plans->amount;
        }
        return view('auth.user.dashboard', compact('plan','total_amount'));
    }

        public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }

public function getPrices($id)
{
    $course = Course::with('course_price')->findOrFail($id);
    return response()->json($course->course_price);
}


public function validateCoupon(Request $request)
{
    $code = $request->input('coupon');

    $coupon = Discount::where('coupon_number', $code)
        ->where('status', 1)
        ->first();

    if (!$coupon) {
        return response()->json([
            'valid' => false,
            'message' => 'Invalid coupon code.'
        ], 404);
    }

    $expiryDate = Carbon::parse($coupon->discount_date)
        ->addDays($coupon->discount_duration_day);

    if (Carbon::now()->gt($expiryDate)) {
        return response()->json([
            'valid' => false,
            'message' => 'This coupon has expired.'
        ], 400);
    }


    return response()->json([
        'valid' => true,
        'discount_id' => $coupon->id,
        'discount_percent' => $coupon->percentage,
        'message' => 'Coupon applied successfully!'
    ]);
}


}
