<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\EmpleatExtern;

class EmpleatExternController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return EmpleatExtern::all();
    }

    public function show() {

    }

    public function insertView() {

    }

    public function insert() {

    }

    public function updateView() {

    }

    public function update() {

    }

    public function delete(Request $request) {

    }
}
