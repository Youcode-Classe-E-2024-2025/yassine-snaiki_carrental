<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;


class RentalController extends Controller
{

    public function index()
    {
        return response()->json(Rental::all());
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'car_id' => 'required|exists:cars,id',
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after:start_date',
    //         'total_price' => 'required|numeric',
    //         'stripe_token' => 'required|string'
    //     ]);
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    // try {
    //     // Charge the user
    //     $charge = Charge::create([
    //         'amount' => $data['total_price'] * 100, // Convert to cents
    //         'currency' => 'usd',
    //         'source' => $data['stripe_token'], // Token from frontend
    //         'description' => 'Car Rental Payment',
    //     ]);

    //     // If payment is successful, create the rental
    //     $rental = Rental::create($data);

    //     // Save payment record (optional)
    //     Payment::create([
    //         'user_id' => $data['user_id'],
    //         'rental_id' => $rental->id,
    //         'amount' => $data['total_price'],
    //         'status' => 'paid',
    //         'payment_id' => $charge->id,
    //         'payment_method' => 'stripe',
    //     ]);
    //     return response()->json($rental, 201);

    // } catch (\Exception $e) {
    //     return response()->json(['error' => $e->getMessage()], 500);
    // }
    // }


public function store(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'car_id' => 'required|exists:cars,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'total_price' => 'required|numeric',
    ]);
    try {
        DB::beginTransaction();
        $rental = Rental::create($data);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Car Rental',
                    ],
                    'unit_amount' => $data['total_price'] * 100, // Convert to cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => env('FRONTEND_URL') . "/payment-success/" . $rental->id,
            'cancel_url' => env('FRONTEND_URL') . "/payment-cancel/" . $rental->id,
            'metadata' => [
                'rental_id' => $rental->id,
                'user_id' => $data['user_id'],
            ],
        ]);

        DB::commit();
        return response()->json(['url' => $session->url]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function show(Rental $rental)
    {
        return response()->json($rental);
    }

    public function getByUser(User $user){
        return response()->json($user->rentals);
    }


    public function getByCar(Car $car) {
        return response()->json($car->rentals);
    }


    public function destroy(Rental $rental)
    {
        return response()->json($rental->delete());
    }

    public function cancel(Rental $rental){
        $rental->delete();
    }
    public function success(Rental $rental){
        Payment::create([
            'user_id' => $rental->user_id,
            'rental_id' => $rental->id,
            'amount' => $rental->total_price,
            'status' => 'paid',
            'payment_method' => 'stripe',
        ]);
    }
}
