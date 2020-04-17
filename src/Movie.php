<?php


namespace Tudublin;


class Movie
{
    const CREATE_TABLE_SQL =
        <<<HERE
CREATE TABLE IF NOT EXISTS movie (
    id integer PRIMARY KEY AUTO_INCREMENT,
    title text,
    category text,
    price float,
    voteTotal integer,
    numVotes integer
)
HERE;

    private $id;
    private $title;
    private $category;
    private $price;
    private $voteTotal;
    private $numVotes;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getNumVotes()
    {
        return $this->numVotes;
    }

    public function setNumVotes($numVotes)
    {
        $this->numVotes = $numVotes;
    }

    public function getVoteTotal()
    {
        return $this->voteTotal;
    }

    public function setVoteTotal($voteTotal)
    {
        $this->voteTotal = $voteTotal;
    }

    /**
     * @return int - integer average vote percentage
     *  (0..100)
     */
    public function getVoteAverage()
    {
        // avoid divide by zero problem ...
        if($this->numVotes < 1){
            return 0;
        }
        return intval($this->voteTotal / $this->numVotes);
    }

    /*
     * 0 - 15 - 40 - 50 - 70 - 85 - 100 %age
     *   .5   1    2    3    4    5     stars
     */
    public function getStarImage()
    {
        if($this->getVoteAverage() > 85){
            return 'stars5.png';
        }
        if($this->getVoteAverage() > 70){
            return 'stars4.png';
        }
        if($this->getVoteAverage() >= 50){
            return 'stars3.png';
        }
        if($this->getVoteAverage() > 40){
            return 'stars2.png';
        }
        if($this->getVoteAverage() > 15){
            return 'stars1.png';
        }

        // if get here, less than 16%, so a half-star
        return 'starsHalf.png';
    }


}