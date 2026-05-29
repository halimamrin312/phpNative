<?php

class Controller
{
    public function view(string $view, $data = [])
    {
        return require_once '../app/views/' . $view . '.php';
    }
    public function model(string $model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }
}