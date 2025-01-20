<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Event;

use Spyck\AccountingBundle\Entity\Invoice;

class CodeEvent
{
    public function __construct(private Invoice $invoice)
    {
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }
}
