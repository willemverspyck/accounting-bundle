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

    public function patchInvoiceCode(Invoice $invoice): void
    {
        $timestamp = new DateTimeImmutable();

        $code = $this->getInvoiceCode($invoice, $timestamp);

        $this->invoiceRepository->patchInvoice(invoice: $invoice, fields: ['code', 'timestamp'], code: $code, timestamp: $timestamp);
    }

    private function getInvoiceCode(Invoice $invoice, DateTimeImmutable $timestamp): string
    {
        if (null !== $invoice->getCode()) {
            return $invoice->getCode();
        }

        $code = $this->invoiceRepository->getInvoiceMaxCode();

        if (null === $code) {
            $code = 1;
        } else {
            $code = (int) $code + 1;
        }

        return sprintf('%s%06s', $timestamp->format('y'), $code);
    }
}
