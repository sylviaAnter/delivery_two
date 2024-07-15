<?php

use App\Models\Invoice;
use App\Models\Region;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/regions', function (Request $request) {
    $q = $request->get('q');
    $company_id = $request->get('company_id');

    if ($company_id == null) {
        return response()->json([
            'data' => [],
        ], 400);
    }

    $regions = Region::where('company_id', $company_id)
        ->where('Region_name', 'like', "%$q%")
        ->orderBy('Region_name', 'asc')
        ->limit(20)
        ->get();

    $data = [];
    foreach ($regions as $region) {
        $data[] = [
            'id' => $region->id,
            'text' => $region->Region_name,
        ];
    }

    return response()->json([
        'data' => $data,
    ]);
});
Route::get('/invoices', function (Request $request) {
    $q = $request->get('q');
    $company_id = $request->get('company_id');

    if ($company_id == null) {
        return response()->json([
            'data' => [],
        ], 400);
    }

    $invoices = Invoice::where('company_id', $company_id)
        ->where('customer_name', 'like', "%$q%")
        ->orderBy('customer_name', 'asc')
        ->limit(20)
        ->get();

    $data = [];
    foreach ($invoices as $invoice) {
        $data[] = [
            'id' => $invoice->id,
            'text' => $invoice->customer_name,
        ];
    }

    return response()->json([
        'data' => $data,
    ]);
});


Route::get('/vehicles', function (Request $request) {
    $q = $request->get('q');
    $company_id = $request->get('company_id');

    if ($company_id == null) {
        return response()->json([
            'data' => [],
        ], 400);
    }

    $vehicles = Vehicle::where('company_id', $company_id)
        ->where('plate_number', 'like', "%$q%")
        ->orderBy('plate_number', 'asc')
        ->limit(20)
        ->get();

    $data = [];
    foreach ($vehicles as $vehicl) {
        $data[] = [
            'id' => $vehicl->id,
            'text' => $vehicl->plate_number,
        ];
    }

    return response()->json([
        'data' => $data,
    ]);
});
