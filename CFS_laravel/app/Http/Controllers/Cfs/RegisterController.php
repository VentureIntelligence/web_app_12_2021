<?php

namespace App\Http\Controllers\Cfs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('companyprofile.login');
    }

    public function regsiter(Request $request)
    {
        $request->validate([
            ''
        ]);
    }
}
