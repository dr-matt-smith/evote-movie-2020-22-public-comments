<?php


namespace Tudublin;


use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

class MovieController extends Controller
{
    public function listMovies()
    {
        $movies = $this->movieRepository->findAll();
        $comments = $this->commentRepository->findAll();

        // reverse array - so most recent comments appear first ...
        $comments = array_reverse($comments);

        $template = 'list.html.twig';
        $args = [
            'movies' => $movies,
            'comments' => $comments
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function delete()
    {
        $id = filter_input(INPUT_GET, 'id');
        $success = $this->movieRepository->delete($id);

        if($success){
            $this->listMovies();
        } else {
            $message = 'there was a problem trying to delete Movie with ID = ' . $id;
            $this->error($message);
        }
    }

    public function error($errorMessage)
    {
        $template = 'error.html.twig';
        $args = [
        'errorMessage' => $errorMessage
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function createForm()
    {
        $template = 'newMovieForm.html.twig';
        $args = [];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processNewMovie()
    {
        $title = filter_input(INPUT_POST, 'title');
        $category = filter_input(INPUT_POST, 'category');
        $price = filter_input(INPUT_POST, 'price');

        $m = new Movie();
        $m->setTitle($title);
        $m->setCategory($category);
        $m->setPrice($price);
        $m->setVoteTotal(0);
        $m->setNumVotes(0);

        $this->movieRepository->create($m);

        $this->listMovies();
    }

    public function edit()
    {
        $id = filter_input(INPUT_GET, 'id');
        $movie = $this->movieRepository->find($id);

        // if not NULL pass Movie object to editForm method
        if($movie){
            $this->editForm($movie);
        } else {
            $message = 'there was a problem trying to edit Movie with ID = ' . $id;
            $this->error($message);
        }
    }


    public function editForm($movie)
    {
        $template = 'editMovieForm.html.twig';
        $args = [
            'movie' => $movie
        ];
        $html = $this->twig->render($template, $args);
        print $html;
    }

    public function processUpdateMovie()
    {
        $id = filter_input(INPUT_POST, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $category = filter_input(INPUT_POST, 'category');
        $price = filter_input(INPUT_POST, 'price');
        $voteTotal = filter_input(INPUT_POST, 'voteTotal');
        $numVotes = filter_input(INPUT_POST, 'numVotes');

        $m = new Movie();
        $m->setId($id);
        $m->setTitle($title);
        $m->setCategory($category);
        $m->setPrice($price);
        $m->setVoteTotal($voteTotal);
        $m->setNumVotes($numVotes);

        $success = $this->movieRepository->update($m);

        if($success){
            $this->listMovies();
        } else {
            $message = 'there was a problem trying to EDIT Movie with ID = ' . $id;
            $this->error($message);
        }
    }


}

