<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function withDraw(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "amount" => "required|integer",
        ]);

        try {

            if ($validate->fails()) {
                return response()->json(["error" => $validate->errors()], 400);
            }

            $amount = $request->input("amount");

            if ($amount % 5 !== 0) {
                return response()->json(["error" => "Solo se permiten multiplos de 5."], 400);
            }

            $cashier = Cashier::First();

            if (!$cashier) {
                return response()->json(["error" => "No se encontro el cajero."], 404);
            }

            $remainingAmount = $amount;
            $billsToWithDraw = [];

            $availableBills = [
                100 => $cashier->bills_100,
                50 => $cashier->bills_50,
                20 => $cashier->bills_20,
                10 => $cashier->bills_10,
                5 => $cashier->bills_5,
                1 => $cashier->bills_1,
            ];

            krsort($availableBills);

            foreach ($availableBills as $billsValue => $quantity) {
                if ($remainingAmount <= 0) {
                    break;
                }

                $billsToUSe = min(intval($remainingAmount / $billsValue), $quantity);
                if ($billsToUSe > 0) {
                    $billsToWithDraw[$billsValue] = $billsToUSe;
                    $remainingAmount -= $billsToUSe * $billsValue;
                }
            }

            if ($remainingAmount > 0) {
                return response()->json(["error" => "No hay suficientes fondos para completar el retiro."], 400);
            }

            foreach ($billsToWithDraw as $billsValue => $quantity) {
                $column = "bills_" . $billsValue;
                $cashier->$column -= $quantity;
            }

            $cashier->save();

            $transaction = new Transaction();

            $transaction->amount = $amount;
            $transaction->id_cashier = $cashier->id;

            $transaction->save();

            return response()->json(["success" => "Retiro realizado exitosamente.", "billetes" => $billsToWithDraw, "total" => $amount], 200);
        } catch (\Exception $error) {
            return response()->json(["error" => $error->getMessage()], 500);
        }
    }
}
