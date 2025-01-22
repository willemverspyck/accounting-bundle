<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Repository;

use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Spyck\AccountingBundle\Entity\Invoice;

class InvoiceRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Invoice::class);
    }

    public function getInvoicesCountWithCodeIsNotNull(): int
    {
        return $this->createQueryBuilder('invoice')
            ->select('COUNT(invoice)')
            ->where('invoice.code IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function patchInvoice(Invoice $invoice, array $fields, ?string $code = null, ?DateTimeImmutable $timestamp = null): void
    {
        if (in_array('code', $fields)) {
            $invoice->setCode($code);
        }

        if (in_array('timestamp', $fields)) {
            $invoice->setTimestamp($timestamp);
        }

        $this->getEntityManager()->persist($invoice);
        $this->getEntityManager()->flush();
    }
}
