<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\User;
use App\Models\Course;
use App\Models\Plan;
use App\Models\CoursePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DataTables;

class UserController extends Controller
{

    public function index() {
		return $this->users();
	}

	public function users(){   

		return view('admin.users.index');
	} 


public function user_list(Request $request)
{
        $users = User::orderBy('created_at', 'desc')->get();
        
        $data = [];
    
        foreach ($users as $index => $user) {

            $action  = '<div class="d-flex flex-wrap gap-1">'; 
            $action .= '<a href="' . route('admin.users.show', $user->id) . '" class="text-info bg-transparent hover-effect p-1 rounded" ><i class="fa-regular fa-eye"></i></a>';
            $action .= '<a href="' . route('admin.users.edit', $user->id) . '" class="text-dark bg-transparent hover-effect p-1 rounded"><i class="fas fa-edit"></i></a>';
            $action .= '<button type="button" class="text-danger bg-transparent hover-effect p-1 rounded"
                onclick="delete_row(\'' . route('admin.users.destroy', ':id') . '\', ' . $user->id . ')">
                <i class="fas fa-trash-alt"></i>
            </button>';
            $action .= '</div>';

            $status = '
            <button id="status-btn-' . $user->id . '"
            onclick="status_change(\'' . route('admin.users.toggle-status', $user->id) . '\', ' . ($user->status == 1 ? 0 : 1) . ', ' . $user->id . ', \'' . ($user->status == 1 ? 'Inactive' : 'Active') . '\')"
            class="text-xs font-semibold inline-block py-1 px-3 rounded-full 
            ' . ($user->status == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') . ' 
            hover:opacity-80 transition-all duration-150">
            ' . ($user->status == 1 ? 'Active' : 'Inactive') . '
            </button>
            <span id="st_loader_' . $user->id . '" style="display:none;">
            <i class="fas fa-spinner fa-spin text-gray-600 text-sm ml-2"></i>
            </span>';

            $data[] = [
                'index' => $index + 1,
                'name' => ucfirst($user->name),
                'phone' => $user->phone,
                'email' => $user->email,
                'referral_id' => $user->referral_id,
                'wallet' => $user->wallet,
                'status' => $status,
                'action' => $action,
            ];
        }

        return response()->json(['data' => $data]);
  
}



    public function create()
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
        return view('admin.users.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => ['required', 'digits:10'],
        'course' => 'required|string|max:255',
        'duration' => 'required|string|max:255',
        'password' => 'required|string|min:8',
        'gender'   => 'required',
        'price'   => 'required',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'gender'    => $validated['gender'],
            'status' => 1,
            'wallet' => 0,

        ]);

        $user->referral_id = strtoupper(Str::random(6)) . '-' . $user->id;
        $user->save();

        $plan = Plan::create([
            'course_id' => $request->course,
            'valid' => $request->duration,
            'referred_by' => $request->referred_by ?? 'self',
            'user_id' => $user->id,
            'amount'   => $request->price
        ]);
    
        if (!empty($user->email)) {
            Mail::to($user->email)->send(new UserConfirmationMail($user));
        }

        return response()->json(['status' => 2, 'message' => 'User created successfully', 'surl' => route('admin.users.index')]);    
    }

    public function edit($id)
    {
       $user = User::findOrFail($id);

       $plan = Plan::with('course')->where('user_id',$user->id)->first();
       
       $coursePrices = CoursePrice::where('course_id', $plan->course_id)->get();

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

      //  echo '<pre>'; print_r($plan->toArray()); die;

        return view('admin.users.edit', compact('user','courses','coursePrices','plan'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        
        $plan = Plan::with('course','users')->where('user_id',$user->id)->first();

        $userName = User::where('referral_id', $plan->referred_by)->value('name') ?? 'Self';

        //echo '<pre>'; print_r($userName); die;
        return view('admin.users.show', compact('user','plan','userName'));
    }

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => ['required', 'digits:10'],
        'course' => 'required|string|max:255',
        'duration' => 'required|string|max:255',
        'gender' => 'required|in:male,female,other',
        'price' => 'required|numeric',
        'status' => 'required|in:1,0',
    ]);

    if ($request->filled('password')) {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);
        $validated['password'] = Hash::make($request->password);
    }

    $user->update($validated);

    $plan = Plan::where('user_id', $user->id)->firstOrFail();

    $previousStatus = $plan->status;

    $plan->update([
        'course_id' => $request->course,
        'valid' => $request->duration,
        'referred_by' => $request->referred_by,
        'user_id' => $user->id,
        'amount' => $request->price,
    ]);

    return response()->json([
        'status' => 2,
        'message' => 'User updated successfully',
        'surl' => route('admin.users.index')
    ]);
}


public function destroy($id)
{
    $user = User::findOrFail($id);

    Plan::where('user_id', $user->id)->delete();

    $user->delete();

    return response()->json([
        'status' => 1,
        'message' => 'User deleted successfully',
        'surl' => route('admin.users.index')
    ]);
}


public function toggleStatus(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'status' => 'required|in:0,1'
    ]);

    $user->status = $validated['status'];
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'new_status' => $user->status,
    ]);
}

}
