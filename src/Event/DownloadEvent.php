<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Event;

use Exception;
use Spyck\AccountingBundle\Entity\Invoice;
use Symfony\Component\HttpFoundation\Response;

class DownloadEvent
{
    private ?Response $response = null;

    public function __construct(private Invoice $invoice)
    {
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setResponse(?Response $response): DownloadEvent
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }
}
