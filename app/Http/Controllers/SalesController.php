<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;

class SalesController extends Controller
{
    public function index()
    {
        return Sale::all();
    }
    public function fetchData(){
        $data = Sales::all();
        return response()->json($data);
    }

public function getSales(Request $request, $userId = null)
{
    if (auth()->user()->name === 'admin') {
        $sales = Sales::all(); // Returns all sales
    } else {
        if ($userId) {
            $sales = Sales::where('users_Id', $userId)->get();
        } else {
            $sales = Sales::where('users_Id', auth()->id())->get();
        }
    }

    return response()->json($sales);
}

    public function completeSale(Request $request)
    {

        $validated = $request->validate([
            'sales' => 'required|array',
            'sales.*.Products_Id' => 'required|integer|exists:Products,id',
            'sales.*.ProductBought' => 'required|string',
            'sales.*.Amount' => 'required|integer|min:1',
            'sales.*.users_Id' => 'required|integer|exists:users,id',
        ]);


        $saleNumber = DB::table('Sales')->max('sale_number') + 1;

        try {

            DB::beginTransaction();

            foreach ($validated['sales'] as $sale) {
                DB::table('Sales')->insert([
                    'Products_Id' => $sale['Products_Id'],
                    'ProductBought' => $sale['ProductBought'],
                    'Amount' => $sale['Amount'],
                    'users_Id' => $sale['users_Id'],
                    'sale_number' => $saleNumber,
                ]);


                DB::table('Products')->where('id', $sale['Products_Id'])->decrement('AmountAvailable', $sale['Amount']);
            }

            DB::commit();

            return response()->json([
                'message' => 'Venta completada con éxito',
                'sale_number' => $saleNumber,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al completar la venta',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
