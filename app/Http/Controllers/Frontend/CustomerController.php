<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCustomer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function register(RequestCustomer $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Customer::insert($data);
        return json_encode(true);
    }
}
