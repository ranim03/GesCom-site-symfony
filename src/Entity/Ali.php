<?php

namespace App\Entity;

use App\Repository\AliRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AliRepository::class)]
class Ali
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
