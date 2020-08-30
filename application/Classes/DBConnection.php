<?php


class DBConnection
{
    private $connection;
    private static $instance;
    private static $dbhost = "localhost";
    private static $dbuser= "root";
    private static $dbpassword = "";
    private static $dbname = "solomono";

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __construct()
    {
        $this->connection = new mysqli("localhost","root","","solomono");
    }
    public function getConnection(){
        return $this->connection;
    }
}