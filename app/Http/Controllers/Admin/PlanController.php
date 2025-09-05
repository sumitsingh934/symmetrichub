<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\User;
use App\Models\Plan;
use App\Models\Course;
use App\Models\CoursePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DataTables;

class PlanController extends Controller
{

    public function index() {
		return $this->plan();
	}

	public function plan(){   
		    return view('admin.plan.index');
	} 


public function plan_list(Request $request)
{
    $plans = Plan::with('users','course')->orderBy('created_at', 'desc')->get();
     
    $data = [];

    foreach ($plans as $index => $plan) {

        $userName = User::where('referral_id', $plan->referred_by)->value('name') ?? 'Self';

        // Action buttons
        $action  = '<div class="d-flex flex-wrap gap-1">';
        $action .= '<a href="' . route('admin.plan.show', $plan->id) . '" class="text-info bg-transparent hover-effect p-1 rounded"><i class="fa-regular fa-eye"></i></a>';
        $action .= '<a href="' . route('admin.plan.edit', $plan->id) . '" class="text-dark bg-transparent hover-effect p-1 rounded"><i class="fas fa-edit"></i></a>';
        $action .= '<button type="button" class="text-danger bg-transparent hover-effect p-1 rounded"
            onclick="delete_row(\'' . route('admin.plan.destroy', ':id') . '\', ' . $plan->id . ')">
            <i class="fas fa-trash-alt"></i>
        </button>';
        $action .= '</div>';

        // Status button
        $status = '
            <button id="status-btn-' . $plan->id . '"
            onclick="plan_status_change(\'' . route('admin.plan.toggle-status', $plan->id) . '\', ' . ($plan->status == 1 ? 0 : 1) . ', ' . $plan->id . ', \'' . ($plan->status == 1 ? 'Inactive' : 'Active') . '\')"
            class="text-xs font-semibold inline-block py-1 px-3 rounded-full 
            ' . ($plan->status == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') . ' 
            hover:opacity-80 transition-all duration-150">
            ' . ($plan->status == 1 ? 'Active' : 'Inactive') . '
            </button>
            <span id="st_loader_' . $plan->id . '" style="display:none;">
            <i class="fas fa-spinner fa-spin text-gray-600 text-sm ml-2"></i>
            </span>';
            if ($plan->valid >= 1 && $plan->valid <= 12) {
                $validity = $plan->valid . ' month' . ($plan->valid > 1 ? 's' : '') . ' (' . ($plan->valid * 30) . ' days)';
            } elseif ($plan->valid == 1) {
                $validity = '1 day';
            } elseif ($plan->valid == 30) {
                $validity = '1 month';
            } else {
                $validity = $plan->valid . ' days';
            }

            if($plan->status == 1){
                $Paidamount = $plan->amount;
            }else{
                $Paidamount = 'Payment No Recive';
            }

        // Add to data array
        $data[] = [
            'index'       => $index + 1,
            'name'        => strtoupper($plan->course->name) ?? 'N/A',
            'referred_by' => ucfirst($userName) ?? 'N/A',
            'user'        => ucfirst($plan->users->name) ?? 'N/A',
            'referral_id' => ucfirst($plan->referred_by) ?? 'N/A',
            'valid'       => $validity ?? 'N/A',
            'actualprice' => $plan->course_price->price ?? 'N/A',
            'amount'      => $Paidamount ?? 'N/A',
            'status'      => $status ?? 'N/A',
            'action'      => $action ?? 'N/A',
        ];
    }

    return response()->json(['data' => $data]);
}


    public function create()
    {
        $users = User::all();
        
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

        return view('admin.plan.create', compact('users','courses'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'user' => 'required|exists:users,id',
        'course' => 'required|array',
        'course.*' => 'exists:courses,id',
        'valids' => 'required|array',
        'valids.*' => 'numeric|nullable',
        'prices' => 'required|array',
        'prices.*' => 'numeric|nullable',
    ]);

    foreach ($validated['course'] as $courseId) {
        $existingPlan = Plan::where('user_id', $validated['user'])
            ->where('course_id', $courseId)
            ->first();

        $plan = Plan::where('user_id', $validated['user'])->first();

        $ref = $plan->referred_by ?? 'self';

        if ($existingPlan) {
            return response()->json([
                'status' => 0,
                'message' => "Plan for course ID {$courseId} already exists for this user."
            ], 422); 
        }

        $valid = $validated['valids'][$courseId] ?? null;
        $price = $validated['prices'][$courseId] ?? null;

        Plan::create([
            'user_id' => $validated['user'],
            'referred_by' => $ref,
            'course_id' => $courseId,
            'valid' => $valid,
            'amount' => $price,
        ]);
    }

    return response()->json([
        'status' => 2,
        'message' => 'Plans created successfully',
        'surl' => route('admin.plan.index'),
    ]);
}





    public function edit($id)
    {
        $plan = Plan::with('users','course')->findOrFail($id);
        // echo '<pre>'; print_r($plan->toArray()); die;
        
        $courseprices = CoursePrice::where('course_id', $plan->course->id)->get();
    
        $users = User::all();

        $courses = Course::all();

        $duration = $plan->valid;

        $userId = $plan->user_id;

        return view('admin.plan.edit', compact('plan','courses','courseprices','duration','userId','users'));
    }

    public function show($id)
    {
        $plan = Plan::with('users','course')->findOrFail($id);
        return view('admin.plan.show', compact('plan'));
    }

public function update(Request $request, $id)
{
    $plan = Plan::findOrFail($id);
    $previousStatus = $plan->status; 

    $validated = $request->validate([
        'course' => 'required|string|max:255',
        'valid' => 'required|integer|min:1',
        'username' => 'required',
        'reffred_by' => 'required',
        'amount' => 'nullable|string',
        'status' => 'required|in:1,0',
    ]);

    $validated['user_id'] = $validated['username'];
    $plan->update($validated);

    $user = User::find($plan->user_id);

    if ($user && $user->referral_id) {
        $ref = User::where('referral_id', $plan->referred_by)->first();

        if ($ref) {

            if ($plan->status == 1 && $previousStatus != 1) {
                $ref->wallet += 20;
            } elseif ($plan->status == 0 && $previousStatus == 1) {
                $ref->wallet = max(0, $ref->wallet - 20);
            }

            $ref->save();
        }
    }

    return response()->json([
        'status' => 2,
        'message' => 'Plan updated successfully',
        'surl' => route('admin.plan.index')
    ]);    
}


public function destroy($id)
{
    $plan = Plan::findOrFail($id);


    $plan->delete();

    return response()->json([
        'status' => 1,
        'message' => 'Plan deleted successfully',
        'surl' => route('admin.plan.index')
    ]);
}


public function toggleStatus(Request $request, $id)
{
    // Validate status input
    $validated = $request->validate([
        'status' => 'required|in:0,1'
    ]);

    $plan = Plan::findOrFail($id);
    $previousStatus = $plan->status;

    $plan->status = $validated['status'];
    $plan->save();

    $user = User::find($plan->user_id);

    if ($user && $user->referral_id) {

        $ref = User::where('referral_id', $plan->referred_by)->first();

        if ($ref) {

            if ($plan->status == 1 && $previousStatus != 1) {
                $ref->wallet += 20;
            } elseif ($plan->status == 0 && $previousStatus != 0) {

                $ref->wallet = max(0, $ref->wallet - 20);
            }

            $ref->save();
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'new_status' => $plan->status,
    ]);
}


}
