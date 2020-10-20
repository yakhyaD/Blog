<?php
namespace App\Model;

use \DateTime;
use App\Helpers\Text;
class Post {

    private $id;

    private $slug;

    private $name;

    private $content;

    private $created_at;

    private $categories = [];

    public function getName (): ?string
    {
        return htmlentities($this->name); 
    }

    public function getCreatedAt (): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getSlug (): ?string
    {
        return $this->slug;
    }

    public function getID (): ?int
    {
        return $this->id;
    }
    public function getExcerpt (): ?string
    {
        if($this->content === null)
        {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content,60)));
    }
    public function getContent(): ?string
    {
        return  nl2br(htmlentities($this->content));
    }
    /**
     * @ Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
}
