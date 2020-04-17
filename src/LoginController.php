<?php


namespace Tudublin;


class LoginController extends Controller
{
    public function isGranted($role)
    {
        if($this->isLoggedIn()){
            $roleInSession = $this->roleFromSession();
            if($role == $roleInSession){
                return true;
            }
        }

        // if get here, then either not logged in, or didn't have specified role
        return false;
    }

    /**
     * if we can find a 'role' element in the sesison, return that
     * otherwise return an empty string
     * @return string
     */
    public function roleFromSession()
    {
        if(isset($_SESSION['role'])){
            return $_SESSION['role'];
        }

        return '';
    }

    public function loginForm()
    {
        $template = 'loginForm.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processLogin()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $role = $this->checkCredentials($username, $password);

        if(!empty($role)){
            // store value in session ...
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $mainController = new MainController();
            $mainController->home();
        } else {
            $movieController = new MovieController();
            $movieController->error('bad username or password');
        }
    }


    public function isLoggedIn()
    {
        if(isset($_SESSION['username'])){
            return true;
        }

        return false;
    }

    public function logout()
    {
        $_SESSION = [];
        $mainController = new MainController();
        $mainController->home();
    }

    /**
     * @param $username
     * @param $password
     * @return string - user role or empty string
     *
     */
    public function checkCredentials($username, $password)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUserName($username);

        if($user) {
            $passwordFromDatabase = $user->getPassword();
            $role = $user->getRole();
            if(password_verify($password, $passwordFromDatabase)){
                return $role;
            }
        }

        return '';
    }
}