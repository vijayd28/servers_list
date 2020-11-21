<?php

namespace App\Entity;

use App\Repository\ServersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServersRepository::class)
 */
class Servers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $model_name;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $ram_size;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $ram_type;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $hdd_size;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $hdd_type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->model_name;
    }

    public function setModelName(string $model_name): self
    {
        $this->model_name = $model_name;

        return $this;
    }

    public function getRamSize(): ?string
    {
        return $this->ram_size;
    }

    public function setRamSize(string $ram_size): self
    {
        $this->ram_size = $ram_size;

        return $this;
    }

    public function getRamType(): ?string
    {
        return $this->ram_type;
    }

    public function setRamType(string $ram_type): self
    {
        $this->ram_type = $ram_type;

        return $this;
    }

    public function getHddSize(): ?string
    {
        return $this->hdd_size;
    }

    public function setHddSize(string $hdd_size): self
    {
        $this->hdd_size = $hdd_size;

        return $this;
    }

    public function getHddType(): ?string
    {
        return $this->hdd_type;
    }

    public function setHddType(string $hdd_type): self
    {
        $this->hdd_type = $hdd_type;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'uuid'     => $this->getUuid(),
            'model'    => $this->getModelName(),
            'ram_size' => $this->getRamSize(),

            'ram_type' => $this->getRamType(),
            'hdd_size' => $this->getHddSize(),
            'hdd_type' => $this->getHddType(),
            'location' => $this->getLocation(),

            'price'    => $this->getPrice(),
            'currency' => $this->getCurrency(),
        ];
    }
}
