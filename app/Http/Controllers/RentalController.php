<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class RentalController extends Controller
{

    public function index()
    {
        return response()->json(Rental::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric',
        ]);
        $rental = Rental::create($data);
        return response()->json($rental);
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
}
