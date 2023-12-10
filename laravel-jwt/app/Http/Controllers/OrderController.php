<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    public function getAll()
    {
        $transactions = Order::all();
        return response()->json($transactions);
    }

    public function select($id)
    {
        $transaction = Order::find($id);
        return response()->json($transaction);
    }}
