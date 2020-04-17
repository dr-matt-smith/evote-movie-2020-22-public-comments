<?php


namespace Tudublin;


class AdminController extends Controller
{
    public function newUserForm()
    {
        $template = 'admin/newUserForm.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processNewUser()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);

        $this->userRepository->create($user);

        $movieController = new MovieController();
        $movieController->listMovies();
    }
}