<?php


namespace Tudublin;


class MainController extends Controller
{
    public function processNewComment()
    {
        $commentText = filter_input(INPUT_POST, 'comment');

        // only create a comment if it's not an empty string
        if(!empty($commentText)) {
            $comment = new Comment();
            $comment->setComment($commentText);
            $this->commentRepository->create($comment);
        }

        // display list of movies (and comments)
        $movieController = new MovieController();
        $movieController->listMovies();
    }

    public function home()
    {
        $template = 'index.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function about()
    {
        $template = 'about.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function contact()
    {
        $template = 'contact.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function sitemap()
    {
        $template = 'sitemap.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }



}