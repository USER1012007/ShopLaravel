<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        echo $request;
        $request->validate([
            'Name' => 'required|string|max:255',
            'Price' => 'required|numeric',
            'AmountAvailable' => 'required|integer',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('picture')) {
            $filePath = $request->file('picture')->store('uploads', 'public');
        }

        $admin = Admin::create([
            'Name' => $request->Name,
            'Price' => $request->Price,
            'AmountAvailable' => $request->AmountAvailable,
            'picture_path' => $filePath,
        ]);

        return response()->json(['message' => 'Item created successfully!', 'data' => $admin], 201);
    }

    public function fetchData(){
        $data = Admin::all();
        return response()->json($data);
    }


    public function destroy($id)
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        $deleted = Admin::where('Id', $id)->delete();
        DB::statement('PRAGMA foreign_keys = ON');
        if ($deleted) {
            return response()->json(['message' => 'Registro eliminado exitosamente'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete record'. $id], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string',
            'Price' => 'required|numeric',
            'AmountAvailable' => 'required|integer',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update($validatedData);

        return response()->json([
            'message' => 'Item updated successfully!',
            'data' => $admin
        ], 200);
    }
}
