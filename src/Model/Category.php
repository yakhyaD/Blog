<?php
namespace App\Model;

class Category {
    private $id;
    private $slug;
    private $name;
    private $post_id;
    private $post;

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return htmlentities($this->slug);
    }

    public function getName(): ?string
    {
        return htmlentities($this->name);
    }
    
    public function getPostID(): ?int
    {
        return $this->post_id;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
    }
}