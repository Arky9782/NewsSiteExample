<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $USD;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $EUR;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $RUB;

    public function getId()
    {
        return $this->id;
    }

    public function getUSD(): ?string
    {
        return $this->USD;
    }

    public function setUSD(string $USD): self
    {
        $this->USD = $USD;

        return $this;
    }

    public function getEUR(): ?string
    {
        return $this->EUR;
    }

    public function setEUR(string $EUR): self
    {
        $this->EUR = $EUR;

        return $this;
    }

    public function getRUB(): ?string
    {
        return $this->RUB;
    }

    public function setRUB(string $RUB): self
    {
        $this->RUB = $RUB;

        return $this;
    }
}
