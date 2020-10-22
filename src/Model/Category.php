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
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name)
    {
        $this->name = htmlentities($name);
        return $this;
    }

    public function setSlug(string $slug)
    {
        $this->slug = htmlentities($slug);
        return $this;
    }
}