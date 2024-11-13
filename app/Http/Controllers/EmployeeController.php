<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // Untuk Melihat seluruh resource employee
    public function index(){
        // Melihat data
        // query builder employee = DB::table('employee')->get();
        $student = Employee::all(); // menggunakan eloquent
        if ($student->isEmpty()) {
            $data = [
                'message' => 'Data employee tidak ditemukan',
                'data' => []
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => 'Get all resource employee',
            'data' => $student
        ];

        return response()->json($data, 200);
    }

    // Untuk menambah resource employee atau karyawan
    public function store (Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'alamat' => 'reqquired|text',
            'email' => 'required|email',
            'status' => 'required',
            'hired_on' => 'required|date'
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'errors' =>$validator->errors()
            ], 422);
        }

        $employee = Employee::create($request->all());

        $data = [
            'message' => 'Data Student berhasil ditambah',
            'data' => $employee,
        ];
        return response()->json($data, 201);
    }

    // untuk melihat single resource employee
    public function show($id){
        $employee = Employee::find($id);
        if($employee){
            $data = [
                'message' => 'Get detail resource employee',
                'data' => $employee
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource employee not found'
            ];
            return response()->json($data, 404);  
        }
    }

    // Untuk memperbarui single resource employee
    public function update(Request $request, $id){
        $employee = Employee::find($id);

        if($employee){
            $input = [
                'name' => $request->name ?? $employee->name,
                'gender' => $request->gender ?? $employee->gender,
                'phone' => $request->phone ?? $employee->phone,
                'alamat' => $request->alamat ?? $employee->alamat,
                'email' => $request->email ?? $employee->email,
                'status' => $request->status ?? $employee->status,
                'hired_on' => $request->hired_on ?? $employee->hired_on
            ];
            // melakukan update data 
            $employee->update($input);
            $data = [
                'message' => 'Data employee berhasil diubah',
                'data' => $employee
            ];

            return response()->json($data, 200);
        } else{
            $data = [
                'message' => 'Data employee gagal diubah'
            ];
            return response()->json($data, 404);
        }
    }

    // Untuk menghapus single resource employee
    public function destroy($id){
        $employee = Employee::find($id); 
        if ($employee){
            $employee->delete();
            $data = [
                'message' => 'Data Berhasil dihapus'
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data tidak berhasil dihapus'
            ];
            return response()->json($data, 404);
        }
    }

    


}