<?php

namespace App;

class Database extends \PDO
{
    protected $db_name = "z904372i_dark";
    protected $db_user = "z904372i_dark";
    protected $db_pass = "sansanich2281337Q";
    protected $db_host = "localhost";
    public function __construct()
    {
        // do nothing
    }

    public function connect()
    {
        try {
            parent::__construct("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}