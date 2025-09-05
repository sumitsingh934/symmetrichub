<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;
use App\Models\Course;
use App\Models\Enquiry;

class DashboardController extends Controller
{
    //
    public function index(){

    $userCount = User::count(); 
    $planCount = Plan::count();
    $courseCount = Course::count();
    $enquiryCount = Enquiry::count();

    $data = [
        'userCount' => $userCount,
        'planCount' => $planCount, 
        'courseCount' => $courseCount, 
        'enquiryCount' => $enquiryCount
    ];  

        return view('admin.dashboard', ['data' => $data]);
    }
}
