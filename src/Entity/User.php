<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    private $sector;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'countFollowers')]
    private $projectsFollowing;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'Participants')]
    private $Participants;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Idea::class)]
    private $idea;

    public function __construct()
    {
        $this->projectsFollowing = new ArrayCollection();
        $this->Participants = new ArrayCollection();
        $this->idea = new ArrayCollection();
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

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjectsFollowing(): Collection
    {
        return $this->projectsFollowing;
    }

    public function addProjectsFollowing(Project $projectsFollowing): self
    {
        if (!$this->projectsFollowing->contains($projectsFollowing)) {
            $this->projectsFollowing[] = $projectsFollowing;
            $projectsFollowing->addCountFollower($this);
        }

        return $this;
    }

    public function removeProjectsFollowing(Project $projectsFollowing): self
    {
        if ($this->projectsFollowing->removeElement($projectsFollowing)) {
            $projectsFollowing->removeCountFollower($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(Project $participant): self
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(Project $participant): self
    {
        $this->Participants->removeElement($participant);

        return $this;
    }

    /**
     * @return Collection<int, Idea>
     */
    public function getIdea(): Collection
    {
        return $this->idea;
    }

    public function addIdea(Idea $idea): self
    {
        if (!$this->idea->contains($idea)) {
            $this->idea[] = $idea;
            $idea->setUser($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): self
    {
        if ($this->idea->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getUser() === $this) {
                $idea->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string the hashed password for this user
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return [];
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() 
    {
        return null;
    }

    /**
     * Returns the identifier for this user (e.g. its username or email address).
     */
    public function getUserIdentifier(): string 
    {
        return '';
    }
}
