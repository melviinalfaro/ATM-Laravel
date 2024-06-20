<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    public function index()
    {
        try {

            $deposits = Cashier::all();

            if ($deposits->isEmpty()) {
                return response()->json(["error" => "No se encontraron depositos."], 400);
            }

            return response()->json(["data" => $deposits], 200);
        } catch (\Exception $error) {
            return response()->json(["error" => $error->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "bills_1" => "nullable|integer|min:0",
            "bills_5" => "nullable|integer|min:0",
            "bills_10" => "nullable|integer|min:0",
            "bills_20" => "nullable|integer|min:0",
            "bills_50" => "nullable|integer|min:0",
            "bills_100" => "nullable|integer|min:0",
        ]);

        try {

            if ($validate->fails()) {
                return response()->json(["error" => $validate->errors()], 400);
            }

            $deposit = Cashier::FirstOrNew();

            $deposit->bills_1 += $request->input("bills_1", 0);
            $deposit->bills_5 += $request->input("bills_5", 0);
            $deposit->bills_10 += $request->input("bills_10", 0);
            $deposit->bills_20 += $request->input("bills_20", 0);
            $deposit->bills_50 += $request->input("bills_50", 0);
            $deposit->bills_100 += $request->input("bills_100", 0);

            $deposit->save();

            return response()->json(["success" => "Deposito realizado exitosamente.", "data" => $deposit], 200);
        } catch (\Exception $error) {
            return response()->json(["error" => $error->getMessage()], 500);
        }
    }
}
