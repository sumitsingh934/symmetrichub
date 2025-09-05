<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CoursePrice;

class CourseController extends Controller
{
    //
    public function index() {
		return $this->products();
	}

	public function products(){   

		return view('admin.courses.index');
	} 

public function course_list(Request $request)
{
    $courses = Course::with('course_price')->orderBy('created_at', 'desc')->get();

    $data = [];

    $i = 1; 
    foreach ($courses as $course) {
        foreach ($course->course_price as $priceOption) {

            $action  = '<div class="d-flex flex-wrap gap-1">';
            $action .= '<a href="' . route('admin.courses.show', $priceOption->id) . '" class="text-info bg-transparent hover-effect p-1 rounded"><i class="fa-regular fa-eye"></i></a>';
            $action .= '<a href="' . route('admin.courses.edit', $priceOption->id) . '" class="text-dark bg-transparent hover-effect p-1 rounded"><i class="fas fa-edit"></i></a>';
            $action .= '<button type="button" class="text-danger bg-transparent hover-effect p-1 rounded"
                onclick="delete_row(\'' . route('admin.courses.destroy', ':id') . '\', ' . $priceOption->id . ')">
                <i class="fas fa-trash-alt"></i>
            </button>';
            $action .= '</div>';

            $status = '
                <button id="status-btn-' . $course->id . '"
                onclick="status_change(\'' . route('admin.courses.toggle-status', $course->id) . '\', ' . ($course->status == 1 ? 0 : 1) . ', ' . $course->id . ', \'' . ($course->status == 1 ? 'Inactive' : 'Active') . '\')"
                class="text-xs font-semibold inline-block py-1 px-3 rounded-full 
                ' . ($course->status == 1 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') . ' 
                hover:opacity-80 transition-all duration-150">
                ' . ($course->status == 1 ? 'Active' : 'Inactive') . '
                </button>
                <span id="st_loader_' . $course->id . '" style="display:none;">
                <i class="fas fa-spinner fa-spin text-gray-600 text-sm ml-2"></i>
                </span>';

   
            $data[] = [
                'index'    => $i++,
                'name'     => strtoupper($course->name),
                'duration' => $priceOption->duration . ' months',
                'amount'   => $priceOption->price . ' ' . $priceOption->currency,
                'status'   => $status,
                'discount'   => $priceOption->discount ??  'N/A',
                'action'   => $action,
            ];
        }
    }

    return response()->json(['data' => $data]);
}


    public function create()
    {
        return view('admin.courses.create');
    }
    
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'duration' => 'required|array',
        'duration.*' => 'integer|min:1|max:12',
        'status' => 'required|string',
    ]);

    $name = $request->input('name');
    
    $course = Course::create([
        'name' => $validated['name'],
        'status' => $validated['status'],
    ]);

    foreach ($validated['duration'] as $month) {
        $priceField = 'price_month_' . $month;
        $priceForDuration = $request->input($priceField);

        if (!is_numeric($priceForDuration)) {
            return response()->json(['status' => 0, 'message' => "Price for duration {$month} is invalid."], 422);
        }

        CoursePrice::create([
            'course_id' => $course->id,
            'duration' => $month,
            'price' => $priceForDuration,
        ]);
    }

    return response()->json([
        'status' => 2,
        'message' => 'Course created successfully',
        'surl' => route('admin.courses.index')
    ]);
}

// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'name' => 'required|string',        
//         'duration' => 'required|array',
//         'duration.*' => 'integer|min:1|max:12',
//     ]);

//     $name = $request->input('name');

//     foreach ($validated['duration'] as $month) {
//         $priceField = 'price_month_' . $month;
//         $priceValue = $request->input($priceField);

//         if ($priceValue !== null) {
//             Price::updateOrCreate(
//                 ['name' => $name, 'month' => $month],
//                 ['price' => $priceValue]
//             );
//         }
//     }

//     return back()->with('success', 'Prices saved successfully.');
// }

    public function edit($id)
    {
        $coursePrice = CoursePrice::with('course')->findOrFail($id);

       // echo '<pre>'; print_r($course->toArray()); die;
        return view('admin.courses.edit', compact('coursePrice'));
    }

    
    public function show($id)
    {
        $coursePrice = CoursePrice::with('course')->findOrFail($id);
        return view('admin.courses.show', compact('coursePrice'));
    }

public function update(Request $request, $id)
{
    $coursePrice = CoursePrice::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',    
        'duration' => 'required',                 
        'price' => 'required|numeric',             
        'status' => 'required|string',                  
    ]);

    $coursePrice->update([
        'duration' => $validated['duration'],
        'price' => $validated['price'],
    ]);

    $course = $coursePrice->course; 

    if ($course) {
        $course->update([
            'name' => $validated['name'],
            'status' => $validated['status'],
        ]);
    }

    return response()->json([
        'status' => 2,
        'message' => 'Course updated successfully',
        'surl' => route('admin.courses.index')
    ]);
}

public function destroy($id)
{
    $coursePrice = CoursePrice::findOrFail($id);

    $coursePrice->delete();

    return response()->json([
        'status' => 1,
        'message' => 'Course deleted successfully',
        'surl' => route('admin.courses.index')
    ]);
}

}
