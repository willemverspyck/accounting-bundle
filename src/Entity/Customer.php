<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as Doctrine;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;

#[Doctrine\Entity]
#[Doctrine\Table(name: 'accounting_customer')]
#[UniqueEntity(fields: 'name')]
class Customer implements Stringable, TimestampInterface
{
    use TimestampTrait;

    #[Doctrine\Column(name: 'id', type: Types::INTEGER, options: ['unsigned' => true])]
    #[Doctrine\Id]
    #[Doctrine\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[Doctrine\Column(name: 'name', type: Types::STRING, length: 128, unique: true)]
    #[Validator\NotBlank]
    private string $name;

    #[Doctrine\Column(name: 'code', type: Types::STRING, length: 8, unique: true, nullable: true)]
    private ?string $code = null;

    #[Doctrine\Column(name: 'contact', type: Types::STRING, length: 128)]
    #[Validator\NotBlank]
    private string $contact;

    #[Doctrine\Column(name: 'address', type: Types::STRING, length: 128)]
    #[Validator\NotBlank]
    private string $address;

    #[Doctrine\Column(name: 'zipcode', type: Types::STRING, length: 8)]
    #[Validator\NotBlank]
    private string $zipcode;

    #[Doctrine\Column(name: 'city', type: Types::STRING, length: 128)]
    #[Validator\NotBlank]
    private string $city;

    #[Doctrine\Column(name: 'country', type: Types::STRING, length: 2)]
    #[Validator\Country]
    #[Validator\NotBlank]
    private string $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function __toString(): string
    {
        $content = $this->getName();

        if (null !== $this->getCode()) {
            $content = sprintf('%s (%s)', $content, $this->getCode());
        }

        return $content;
    }
}
