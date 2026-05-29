<?php

class Home extends Controller
{
    public function index()
    {
        $data['judul'] = 'myLocker';
        return $this->view('home/index', $data);
    }
}