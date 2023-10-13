<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $introduction;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    private $coverImage;

    #[ORM\Column(type: 'string', length: 255)]
    private $Audio;

    #[ORM\OneToMany(mappedBy: 'episode', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\Column(type: 'datetime_immutable', options:['default' => 'CURRENT_TIMESTAMP'])]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'episode', targetEntity: Articles::class)]
    private $article;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $PublishDate = null;

    public function __toString(){
        return $this->title; // Remplacer champ par une propriété "string" de l'entité
    }
    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->article = new ArrayCollection();
        $this->PublishDate = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->Audio;
    }

    public function setAudio(string $Audio): self
    {
        $this->Audio = $Audio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEpisode($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEpisode() === $this) {
                $comment->setEpisode(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setEpisode($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getEpisode() === $this) {
                $article->setEpisode(null);
            }
        }

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->PublishDate;
    }

    public function setPublishDate(?\DateTimeInterface $PublishDate): static
    {
        $this->PublishDate = $PublishDate;

        return $this;
    }
}
