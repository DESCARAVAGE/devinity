<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'projectsFollowing')]
    private $countFollowers;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Participants')]
    private $Participants;

    #[ORM\ManyToOne(targetEntity: status::class, inversedBy: 'projects')]
    private $status;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Idea::class)]
    private $ideas;

    public function __construct()
    {
        $this->countFollowers = new ArrayCollection();
        $this->Participants = new ArrayCollection();
        $this->ideas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getCountFollowers(): Collection
    {
        return $this->countFollowers;
    }

    public function addCountFollower(User $countFollower): self
    {
        if (!$this->countFollowers->contains($countFollower)) {
            $this->countFollowers[] = $countFollower;
        }

        return $this;
    }

    public function removeCountFollower(User $countFollower): self
    {
        $this->countFollowers->removeElement($countFollower);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants[] = $participant;
            $participant->addParticipant($this);
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        if ($this->Participants->removeElement($participant)) {
            $participant->removeParticipant($this);
        }

        return $this;
    }

    public function getStatus(): ?status
    {
        return $this->status;
    }

    public function setStatus(?status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Idea>
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas[] = $idea;
            $idea->setProject($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->ideas->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getProject() === $this) {
                $idea->setProject(null);
            }
        }

        return $this;
    }
}
