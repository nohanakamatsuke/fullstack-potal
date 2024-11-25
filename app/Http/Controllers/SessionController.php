<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function session(Request $request)
    {
        $id = '_2222';
        $name = '釜付 野花';
        // $password = 'password';

        // dd( $id, $name );
        return view('home');
    }
}
