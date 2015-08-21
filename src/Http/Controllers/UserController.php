<?php namespace Speelpenning\Authentication\Http\Controllers;

use Illuminate\Routing\Controller;

class UserController extends Controller
{

    public function create()
    {
        return view('authentication::user.create');
    }

}
