<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as Doctrine;
use Stringable;
use Symfony\Component\Validator\Constraints as Validator;

#[Doctrine\Entity]
#[Doctrine\Table(name: 'accounting_job')]
class Job implements Stringable, TimestampInterface
{
    use TimestampTrait;

    #[Doctrine\Column(name: 'id', type: Types::INTEGER, options: ['unsigned' => true])]
    #[Doctrine\Id]
    #[Doctrine\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[Doctrine\ManyToOne(targetEntity: Invoice::class, inversedBy: 'jobs')]
    #[Doctrine\JoinColumn(name: 'invoice_id', referencedColumnName: 'id', nullable: false)]
    private Invoice $invoice;

    #[Doctrine\ManyToOne(targetEntity: Service::class)]
    #[Doctrine\JoinColumn(name: 'service_id', referencedColumnName: 'id', nullable: false)]
    private Service $service;

    #[Doctrine\Column(name: 'name', type: Types::STRING, length: 192, nullable: true)]
    #[Validator\NotBlank]
    private ?string $name = null;

    #[Doctrine\Column(name: 'quantity', type: Types::FLOAT)]
    private float $quantity;

    #[Doctrine\Column(name: 'amount', type: Types::FLOAT)]
    private float $amount;

    #[Doctrine\Column(name: 'tax', type: Types::BOOLEAN)]
    private bool $tax;

    #[Doctrine\Column(name: 'tax_rate', type: Types::FLOAT)]
    private float $taxRate;

    #[Doctrine\Column(name: 'date', type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
