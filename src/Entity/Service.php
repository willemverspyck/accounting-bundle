<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as Doctrine;
use Stringable;
use Symfony\Component\Validator\Constraints as Validator;

#[Doctrine\Entity]
#[Doctrine\Table(name: 'accounting_service')]
class Service implements Stringable, TimestampInterface
{
    use TimestampTrait;

    #[Doctrine\Column(name: 'id', type: Types::INTEGER, options: ['unsigned' => true])]
    #[Doctrine\Id]
    #[Doctrine\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[Doctrine\Column(name: 'name', type: Types::STRING, length: 192)]
    #[Validator\NotBlank]
    private string $name;

    #[Doctrine\Column(name: 'amount', type: Types::FLOAT)]
    private float $amount;

    #[Doctrine\Column(name: 'tax', type: Types::BOOLEAN)]
    private bool $tax;

    #[Doctrine\Column(name: 'tax_rate', type: Types::FLOAT)]
    private float $taxRate;

    #[Doctrine\Column(name: 'active', type: Types::BOOLEAN)]
    private bool $active;

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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function hasTax(): bool
    {
        return $this->tax;
    }

    public function setTax(bool $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
