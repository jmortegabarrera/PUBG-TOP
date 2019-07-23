<?php

class Conection
{
    const HOST = "localhost";
    const DATABASE_NAME = "test";
    const USER = "root";
    const PASSWORD = '';


    public static function getConection()
    {
        return mysqli_connect(static::HOST, static::USER, static::PASSWORD, static::DATABASE_NAME);
    }

    public static function closeConection($conection, $result)
    {
        mysqli_free_result($result);
        mysqli_close($conection);
    }
}