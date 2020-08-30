<?php


class Controller_Main extends Controller
{
    public function Start()
    {
        $this->model = new Model_main();
        View::Generate("MainView", $this->model);
    }
}