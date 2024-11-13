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
                'message' => 'Employee employee not found'
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

// Untuk search resource
public function searchResource(Request $request)
{
    // Ambil parameter 'name' dari request
    $name = $request->input('name');

    // Cari resource berdasarkan 'name' menggunakan Eloquent
    $resources = Employee::where('name', 'like', '%' . $name . '%')
    ->get(['name', 'gender', 'phone', 'alamat', 'email', 'status', 'hired_on']); // Menampilkan kolom tertentu

    // Cek apakah resource ditemukan
    if ($resources->isEmpty()) {
        // Jika tidak ditemukan, kembalikan respons 404
        return response()->json([
            'message' => 'Employee not found',
        ], 404);
    }

    // Jika ditemukan, kembalikan respons 200 dengan data
    return response()->json([
        'message' => 'Get searched resource',
        'data' => $resources,
    ], 200);
}

// Untuk mendapatkan semua resource yang aktif (misalnya `status` bernilai 'active')
public function getActiveResource(){
    $activeResources = Employee::where('status', 'active')
        ->get(['name', 'gender', 'phone', 'alamat', 'email', 'status', 'hired_on']); // Menampilkan kolom tertentu

    // Jika resource aktif ditemukan, kembalikan respons dengan kode 200
    return response()->json([
        'message' => 'Get active resource',
        'total' => $activeResources->count(),
        'data' => $activeResources,
    ], 200);
}

 // Untuk mendapatkan semua resource yang berstatus 'inactive'
public function getInactiveResource(){
    $inactiveResources = Employee::where('status', 'inactive')
        ->get(['name', 'gender', 'phone', 'alamat', 'email', 'status', 'hired_on']); // Menampilkan kolom tertentu

    // Jika resource inactive ditemukan, kembalikan respons dengan kode 200
    return response()->json([
        'message' => 'Get inactive resource',
        'total' => $inactiveResources->count(),
        'data' => $inactiveResources,
    ], 200);
}

// Untuk mendapatkan semua resource yang berstatus 'terminated'
public function getTerminatedResource(){
    $terminatedResources = Employee::where('status', 'terminated')
        ->get(['name', 'gender', 'phone', 'alamat', 'email', 'status', 'hired_on']); // Menampilkan kolom tertentu

    // Jika resource terminated ditemukan, kembalikan respons dengan kode 200
    return response()->json([
        'message' => 'Get terminated resource',
        'total' => $terminatedResources->count(),
        'data' => $terminatedResources,
    ], 200);
}



}