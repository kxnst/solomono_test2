<?php


class Controller_api extends Controller
{

    public function __construct()
    {
        $this->model = new Model_api();
    }

    public function Start()
    {
        View::Generate("ApiView",$this->model->getItems());
    }
    public function getItem(){
        View::Generate("ApiView",$this->model->getItem());
    }
}