<?php


namespace Tudublin;


use Symfony\Component\Dotenv\Dotenv;

class DotEnvLoader
{

    public function loadDBConstantsFromDotenv()
    {
        // load dotenv file
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');

        // extract values
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_NAME'];

        // declare global constants for pdo-crud-for-free-repositories
        define('DB_USER', $user);
        define('DB_PASS', $password);
        define('DB_HOST', $host . ":" . $port);
        define('DB_NAME', $database);
    }
}