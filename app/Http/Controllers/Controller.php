<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function alerta($message, $type)
    {
        session()->flash('message', $message);
        session()->flash('type', $type);
    }
}
