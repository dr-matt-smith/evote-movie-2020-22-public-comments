<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Tudublin\CommentRepository;
use \Tudublin\DotEnvLoader;

// load DB constants from DOTENV
$dotEnvLoader = new DotEnvLoader();
$dotEnvLoader->loadDBConstantsFromDotenv();

$commentRespository = new CommentRepository();

// (1) drop then create table
$commentRespository->dropTable();
$commentRespository->createTable();

// (2) delete any existing objects
$commentRespository->deleteAll();

