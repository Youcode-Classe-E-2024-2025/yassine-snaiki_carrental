<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(Payment::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:credit_card,paypal,cash',
            'status' => 'required|in:pending,completed,failed',
        ]);
        $payment = Payment::create($request->all());
        return response()->json($payment);
    }


    public function show(Payment $payment)
    {
        return response()->json($payment);
    }

    public function getByUser(User $user) {
        return response()->json($user->payments);
    }

    public function getByRental(Rental $rental) {
        return response()->json($rental->payments);
    }
}
