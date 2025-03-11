<?php

namespace App\Http\Controllers;

use App\Models\car;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function index()
    {
        return response()->json(car::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'price_per_day' => 'required',
            'is_available' => 'required',
        ]);
        $car = car::create($data);
        return response()->json($car);
    }

    public function show(Car $car)
    {
        return response()->json($car);
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'price_per_day' => 'required',
            'is_available' => 'required',
        ]);
        $car->update($data);
        return response()->json($car);
    }
    public function patch(Request $request, Car $car)
    {
        $data = $request->validate([
            'brand' => '',
            'model' => '',
            'year' => '',
            'price_per_day' => '',
            'is_available' => '',
        ]);
        $car->update($data);
        return response()->json($car);
    }


    public function destroy(car $car)
    {
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully']);
    }
}
