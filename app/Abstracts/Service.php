<?php

namespace App\Abstracts;

use Illuminate\Foundation\Http\FormRequest;

abstract class Service
{
    public function getRequestInstance($request)
    {
        if (!is_array($request)) {
            return $request;
        }

        $class = new class() extends FormRequest {};

        return $class->merge($request);
    }
}
