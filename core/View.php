<?php


class View
{
    public static function Generate($templateName,$data = []){
        require_once "application/Views/$templateName.php";
    }
}