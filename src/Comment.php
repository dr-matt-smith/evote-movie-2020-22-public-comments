<?php


namespace Tudublin;


class Comment
{
    const CREATE_TABLE_SQL =
        <<<HERE
CREATE TABLE IF NOT EXISTS comment (
    id integer PRIMARY KEY AUTO_INCREMENT,
    comment text
)
HERE;

    private $id;
    private $comment;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}