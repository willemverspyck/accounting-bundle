<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as Doctrine;
use Stringable;
use Symfony\Component\Validator\Constraints as Validator;

#[Doctrine\Entity]
#[Doctrine\Table(name: 'accounting_invoice')]
class Invoice implements Stringable, TimestampInterface
{
    use TimestampTrait;

    #[Doctrine\Column(name: 'id', type: Types::INTEGER, options: ['unsigned' => true])]
    #[Doctrine\Id]
    #[Doctrine\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[Doctrine\ManyToOne(targetEntity: Customer::class, inversedBy: 'invoices')]
    #[Doctrine\JoinColumn(name: 'customer_id', referencedColumnName: 'id', nullable: false)]
    private Customer $customer;

    #[Doctrine\Column(name: 'name', type: Types::STRING, length: 192, nullable: true)]
    #[Validator\NotBlank]
    private ?string $name = null;

    #[Doctrine\Column(name: 'code', type: Types::STRING, length: 8, unique: true, nullable: true)]
    private ?string $code = null;

    #[Doctrine\Column(name: 'data', type: Types::JSON, nullable: true)]
    private ?array $data = null;

    #[Doctrine\Column(name: 'amount', type: Types::FLOAT, nullable: true)]
    private ?float $amount = null;

    #[Doctrine\Column(name: 'amount_tax', type: Types::FLOAT, nullable: true)]
    private ?float $amountTax = null;

    #[Doctrine\Column(name: 'timestamp', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $timestamp = null;

    #[Doctrine\Column(name: 'timestamp_payment', type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $timestampPayment = null;

    /**
     * @var Collection<int, Job>
     */
    #[Doctrine\OneToMany(mappedBy: 'invoice', targetEntity: Job::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmountTax(): ?float
    {
        return $this->amountTax;
    }

    public function setAmountTax(?float $amountTax): self
    {
        $this->amountTax = $amountTax;

        return $this;
    }

    public function getTimestamp(): ?DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(?DateTimeImmutable $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestampPayment(): ?DateTimeImmutable
    {
        return $this->timestampPayment;
    }

    public function setTimestampPayment(?DateTimeImmutable $timestampPayment): self
    {
        $this->timestampPayment = $timestampPayment;

        return $this;
    }

    public function addJob(Job $job): self
    {
        $job->setInvoice($this);

        $this->jobs->add($job);

        return $this;
    }

    public function clearJobs(): void
    {
        $this->jobs->clear();
    }

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function removeJob(Job $job): void
    {
        $this->jobs->removeElement($job);
    }

    public function getNumber(): ?string
    {
        if (null === $this->getTimestamp() || null === $this->getCode()) {
            return null;
        }

        return sprintf('%d%06d', $this->getTimestamp()->format('y'), $this->getCode());
    }

    public function __toString(): string
    {
        if (null === $this->getName()) {
            return '';
        }

        return $this->getName();
    }
}
