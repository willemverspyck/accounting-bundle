<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Spyck\AccountingBundle\Entity\Job;

#[AsEntityListener(event: Events::prePersist, entity: Job::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Job::class)]
final class JobListener extends AbstractListener
{
    public function prePersist(Job $job): void
    {
        $this->patchInvoice($job->getInvoice());
    }

    public function preUpdate(Job $job): void
    {
        $this->patchInvoice($job->getInvoice());
    }
}
