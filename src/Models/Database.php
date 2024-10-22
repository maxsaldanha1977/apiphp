<?php 

namespace App\Models;

use PDO;

class Database 
{
    public static function getConnection()
    {
        $pdo = new PDO("mysql:host=localhost;port=3304;dbname=api", "root", "");

        return $pdo;
    }
}