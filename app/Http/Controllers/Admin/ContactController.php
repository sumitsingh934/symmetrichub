<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class ContactController extends Controller
{
    //
    public function index() {
		return $this->contact();
	}

	public function contact(){   
		return view('admin.contact.index');
	} 

    public function contact_list(){
     
        $contacts = Enquiry::orderBy('created_at', 'desc')->get();
        
        $data = [];
    
        foreach ($contacts as $index => $contact) {

            $action  = '<div class="d-flex flex-wrap gap-1">'; 
            $action .= '<button type="button" class="text-danger bg-transparent hover-effect p-1 rounded"
                onclick="delete_row(\'' . route('admin.contact.destroy', ':id') . '\', ' . $contact->id . ')">
                <i class="fas fa-trash-alt"></i>
            </button>';
            $action .= '</div>';

            $data[] = [
                'index' => $index + 1,
                'name' => ucfirst($contact->name),
                'email' => $contact->email,
                'phone' => $contact->phone,
                'message' => $contact->message,
                'action' => $action,
            ];
        }

        return response()->json(['data' => $data]);

    }

    public function destroy($id)
   {
    $contact = Enquiry::findOrFail($id);
    
    $contact->delete();

    return response()->json([
        'status' => 1,
        'message' => 'Contact deleted successfully',
        'surl' => route('admin.contact.index')
    ]);
  }

}
