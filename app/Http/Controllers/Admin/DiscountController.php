<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Discount;
use Carbon\Carbon;

class DiscountController extends Controller
{
    //

    public function index() {
		return $this->discount();
	}

	public function discount(){   
		return view('admin.discounts.index');
	} 

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function search(Request $request)
    {
        $search = $request->q;
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $text = "Days{$i}";

            if (!$search || stripos($text, $search) !== false) {
                $data[] = [
                    "id" => $i,
                    "text" => $text
                ];
            }
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'discounts' => 'required',
        'coupon_number' => 'required|string|unique:discounts,coupon_number',
        'percent' => 'required',
        'description' => 'required',
        'discount_date' => 'required',
        'status' => 'required',
        ]);

        //echo '<pre>'; print_r($validated); die;

        $discount = Discount::create([
            'title' => $validated['title'],
            'discount_duration_day' => $validated['discounts'],
            'discount_date' => $validated['discount_date'],
            'coupon_number' => $validated['coupon_number'],
            'percentage' => $validated['percent'],
            'description' => $validated['description'],
            'status' => $validated['status'],

        ]);

        return response()->json(['status' => 2, 'message' => 'Discount created successfully', 'surl' => route('admin.discounts.index')]);  
    }

public function discount_list(Request $request)
{
    $timezone = 'Asia/Kolkata';
    $totalData = Discount::count();
    $totalFiltered = $totalData;

    $discounts = Discount::orderBy('created_at', 'desc')
        ->skip($request->start)
        ->take($request->length)
        ->get();

    $data = [];

    foreach ($discounts as $index => $discount) {

        $action  = '<div class="d-flex flex-wrap gap-1">';
        $action .= '<a href="' . route('admin.discounts.show', $discount->id) . '" class="text-info bg-transparent hover-effect p-1 rounded"><i class="fa-regular fa-eye"></i></a>';
        $action .= '<a href="' . route('admin.discounts.edit', $discount->id) . '" class="text-dark bg-transparent hover-effect p-1 rounded"><i class="fas fa-edit"></i></a>';
        $action .= '<button type="button" class="text-danger bg-transparent hover-effect p-1 rounded"
            onclick="delete_row(\'' . route('admin.discounts.destroy', ':id') . '\', ' . $discount->id . ')">
            <i class="fas fa-trash-alt"></i>
        </button>';
        $action .= '</div>';

        $status = '
        <button id="status-btn-' . $discount->id . '"
        onclick="status_change(\'' . route('admin.discounts.toggle-status', $discount->id) . '\', ' . ($discount->status == 1 ? 0 : 1) . ', ' . $discount->id . ', \'' . ($discount->status == 1 ? 'Inactive' : 'Active') . '\')"
        class="text-xs font-semibold inline-block py-1 px-3 rounded-full 
        ' . ($discount->status == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') . ' 
        hover:opacity-80 transition-all duration-150">
        ' . ($discount->status == 1 ? 'Active' : 'Inactive') . '
        </button>
        <span id="st_loader_' . $discount->id . '" style="display:none;">
        <i class="fas fa-spinner fa-spin text-gray-600 text-sm ml-2"></i>
        </span>';

        $data[] = [
            'index' => $index + 1,
            'title' => ucfirst($discount->title),
            'discount' => $discount->discount_duration_day . ' Days',
            'percent' => $discount->percentage.'%',
            'coupon' => $discount->coupon_number,
            'discount_date' => $discount->discount_date,
            'duration_days' => $discount->discount_duration_day,
            'start_date' => Carbon::parse($discount->discount_date)->format('Y-m-d'), // important for countdown
            'status' => $status,
            'action' => $action,
        ];
    }

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'data' => $data,
    ]);
}


public function edit($id){
 
   $discount = Discount::findOrFail($id);

   //echo '<pre>'; print_r($discount->toArray()); die;
   return view('admin.discounts.edit', compact('discount'));
}

public function show($id){
 
   $discount = Discount::findOrFail($id);

   return view('admin.discounts.show', compact('discount'));
}


public function update(Request $request, $id)
{
    $discount = Discount::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'discounts' => 'required',
        'coupon_number' => 'required',
        'percent' => 'required',
        'discount_date' => 'required',
        'description' => 'required',
        'status' => 'required',
    ]);

    $discount->update([
        'title' => $validated['title'],
        'discount_duration_day' => $validated['discounts'],
        'discount_date' => $validated['discount_date'],
        'coupon_number' => $validated['coupon_number'],
        'percentage' => $validated['percent'],
        'description' => $validated['description'],
        'status' => $validated['status'],
    ]);

    return response()->json([
        'status' => 2,
        'message' => 'Discount updated successfully',
        'surl' => route('admin.discounts.index')
    ]);
}

public function toggleStatus(Request $request, $id)
{
    $discount = Discount::findOrFail($id);
    

    $validated = $request->validate([
        'status' => 'required|in:0,1'
    ]);

    $discount->status = $validated['status'];
    $discount->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'new_status' => $discount->status,
    ]);
}

public function destroy($id)
{
    $discount = Discount::findOrFail($id);

    $discount->delete();

    return response()->json([
        'status' => 1,
        'message' => 'Discount deleted successfully',
        'surl' => route('admin.discounts.index')
    ]);
}

}