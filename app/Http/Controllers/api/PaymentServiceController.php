<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class PaymentServiceController extends Controller
{

    public function getUser(Request $request) {
        return $request->user();
    }

    public function create() {
        return response()->json([
            'create'=>'test successful'
        ]);
    }
}
