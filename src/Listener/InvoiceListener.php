<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Spyck\AccountingBundle\Entity\Invoice;

#[AsEntityListener(event: Events::prePersist, entity: Invoice::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Invoice::class)]
final class InvoiceListener extends AbstractListener
{
    public function prePersist(Invoice $invoice): void
    {
        $this->patchInvoice($invoice);
    }

    public function preUpdate(Invoice $invoice): void
    {
        $this->patchInvoice($invoice);
    }
}
