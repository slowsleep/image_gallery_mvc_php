<?php

class Logout_Controller extends Controller
{
    public function index()
    {
        User_Model::logout();
    }
}
