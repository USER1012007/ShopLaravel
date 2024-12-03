<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Example;

class ExampleController extends Controller
{
    public function fetchData()
    {
        $data = Example::all();
        return response()->json($data);
    }
}
