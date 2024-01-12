<?php

namespace App\Entity;

// Reliquat d'une méthode abandonnée pour faire un semblant de CRON, volontairement laissé pour en parler en feedback

use App\Repository\RunningScriptRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RunningScriptRepository::class)]
class RunningScript
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $IsRunning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsRunning(): ?bool
    {
        return $this->IsRunning;
    }

    public function setIsRunning(bool $IsRunning): static
    {
        $this->IsRunning = $IsRunning;

        return $this;
    }
}
