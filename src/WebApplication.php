<?php


namespace Tudublin;

use Symfony\Component\Dotenv\Dotenv;
class WebApplication
{
    private $mainController;
    private $movieController;
    private $loginController;
    private $adminContoller;
    
    public function __construct()
    {
        $this->mainController = new MainController();
        $this->movieController = new MovieController();
        $this->loginController = new LoginController();
        $this->adminContoller = new AdminController();

        $dotEnvLoader = new DotEnvLoader();
        $dotEnvLoader->loadDBConstantsFromDotenv();
    }

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

    public function run()
    {
        $action = filter_input(INPUT_GET, 'action');
        if (empty($action)) {
            $action = filter_input(INPUT_POST, 'action');
        }

        $module = filter_input(INPUT_GET, 'module');
        if (empty($module)) {
            $module = filter_input(INPUT_POST, 'module');
        }

        switch ($module) {
            case 'admin':
                if ($this->loginController->isGranted('ROLE_ADMIN')) {
                    $this->adminFunctions($action);
                } else {
                    $this->movieController->error('you are not authorised for this action');
                }
                break;
                
            default:
                $this->defaultFunctions($action);
        }
    }
    
    private function defaultFunctions($action)
    {
        switch ($action) {
            case 'processComment':
                $this->mainController->processNewComment();
                break;

            case 'processLogin':
                $this->loginController->processLogin();
                break;

            case 'logout':
                $this->loginController->logout();
                break;

            case 'login':
                $this->loginController->loginForm();
                break;

            case 'processEditMovie':
                if($this->loginController->isLoggedIn()){
                    $this->movieController->processUpdateMovie();
                } else {
                    $this->movieController->error('you are not authorised for this action');
                }
                break;

            case 'editMovie':
                $this->movieController->edit();
                break;

            case 'processNewMovie':
                if($this->loginController->isLoggedIn()){
                    $this->movieController->processNewMovie();
                } else {
                    $this->movieController->error('you are not authorised for this action');
                }
                break;

            case 'newMovieForm':
                $this->movieController->createForm();
                break;

            case 'deleteMovie':
                if($this->loginController->isLoggedIn()){
                    $this->movieController->delete();
                } else {
                    $this->movieController->error('you are not authorised for this action');
                }
                break;

            case 'about':
                $this->mainController->about();
                break;

            case 'contact':
                $this->mainController->contact();
                break;

            case 'list':
                $this->movieController->listMovies();
                break;

            case 'sitemap':
                $this->mainController->sitemap();
                break;

            default:
                $this->mainController->home();
        }
    }
    
    private function adminFunctions($action)
    {
        switch ($action) {
            case 'processNewUser':
                $this->adminContoller->processNewUser();
                break;

            case 'newUserForm':
                $this->adminContoller->newUserForm();
                break;

            default:
                $this->mainController->home();
        }
    }
}