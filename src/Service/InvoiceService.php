<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Service;

use DateTimeImmutable;
use Spyck\AccountingBundle\Entity\Invoice;
use Spyck\AccountingBundle\Repository\InvoiceRepository;

readonly class InvoiceService
{
    public function __construct(private InvoiceRepository $invoiceRepository)
    {
    }

    public function patchInvoice(Invoice $invoice): void
    {
        if (null !== $invoice->getCode()) {
            return;
        }

        $count = $this->invoiceRepository->getInvoicesCountWithCodeIsNotNull() + 1;

        $timestamp = new DateTimeImmutable();

        $code = sprintf('%s%06s', $timestamp->format('y'), $count);

        $this->invoiceRepository->patchInvoice(invoice: $invoice, fields: ['code', 'timestamp'], code: $code, timestamp: $timestamp);
    }
}
