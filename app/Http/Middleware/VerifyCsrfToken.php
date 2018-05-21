<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'product/detail/upload-file',
        'product/detail/remove-file',
        'product/image/upload',
        'product/image/remove',
        'config/info/logo/upload',
        'config/info/logo/remove',
    ];
}
