<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Models\Students;

class StudentController extends Controller
{
    function list(){
       return Students::all();
    }

    function addStudent(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|min:10',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }else{
        $student =  new Students();
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        if($student->save()){
            return ['result'=> 'Added'];
        }else{
            return ['result'=> 'Error'];
        }
    }

    }


    public function updateStudent(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'id' => 'required|exists:students,id', // Ensure the student ID exists in the database
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Find the student by ID
        $student = Students::find($validated['id']);

        // Update the student details
        $student->name = $validated['name'];
        $student->phone = $validated['phone'];
        $student->email = $validated['email'];

        // Save and return a response
        if ($student->save()) {
            return response()->json(['result' => 'Updated successfully'], 200);
        } else {
            return response()->json(['result' => 'Error updating record'], 500);
        }
    }
    public function deleteStudent($id)
    {
        $student = Students::destroy($id);
        if ($student) {
            return response()->json(['result' => 'deleted successfully'], 200);
        } else {
            return response()->json(['result' => 'Error updating record'], 500);
        }
    }
    public function searchStudent($name){
        $student = Students::where('name','like',"%$name%")->get();
        if($student){
            return response()->json(['result' => $student], 200);
        }else{
            return response()->json(['result' => 'Error updating record'], 500);
        }

    }


}
