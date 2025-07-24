<?php
declare(strict_types=1);

namespace App\Entity;
use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $subRegion = null;

    #[ORM\Column(length: 255)]
    private ?string $demonym = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\Column]
    private ?bool $independant = null;

    #[ORM\Column(length: 255)]
    private ?string $flag = null;

    #[ORM\Column(length: 255)]
    private ?string $currencyName = null;

    #[ORM\Column(length: 10)]
    private ?string $currencySymbol = null;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }
    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getSubRegion(): ?string
    {
        return $this->subRegion;
    }

    public function setSubRegion(string $subRegion): static
    {
        $this->subRegion = $subRegion;

        return $this;
    }

    public function getDemonym(): ?string
    {
        return $this->demonym;
    }

    public function setDemonym(string $demonym): static
    {
        $this->demonym = $demonym;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): static
    {
        $this->population = $population;

        return $this;
    }

    public function isIndependant(): ?bool
    {
        return $this->independant;
    }

    public function setIndependant(bool $independant): static
    {
        $this->independant = $independant;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): static
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getCurrencySymbol(): ?string
    {
        return $this->currencySymbol;
    }

    public function setCurrencySymbol(string $currencySymbol): static
    {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }

}