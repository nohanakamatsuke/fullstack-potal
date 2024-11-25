<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected function tokensMatch($request)
    {
        $result = parent::tokensMatch($request);

        if (! $result) {
            \Log::error('CSRF token mismatch', [
                'session_token' => $request->session()->token(),
                'header_token' => $request->header('X-CSRF-TOKEN'),
                'payload_token' => $request->input('_token'),
            ]);
        }

        return $result;
    }
}
