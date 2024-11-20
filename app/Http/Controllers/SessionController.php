<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller {
    public function session() {
        dd( $id, $name );
        $id = '_2222';
        $name = '釜付 野花';
        dd( $id, $name );
        return view( 'components.layouts.header', compact( 'id', 'name' ) );
    }
}
