<?php

declare(strict_types=1);

namespace Spyck\VisualizationBundle\Event\Subscriber;

use Spyck\AccountingBundle\Event\CodeEvent;
use Spyck\AccountingBundle\Service\InvoiceService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CodeEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly InvoiceService $invoiceService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CodeEvent::class => 'onCodeEvent',
        ];
    }

    public function onCodeEvent(CodeEvent $event): void
    {
        $this->invoiceService->patchInvoice($event->getInvoice());
    }
}
