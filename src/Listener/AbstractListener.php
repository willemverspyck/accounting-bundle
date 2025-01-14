<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Listener;

use Spyck\AccountingBundle\Entity\Invoice;

abstract class AbstractListener
{
    protected function patchInvoice(Invoice $invoice): void
    {
        if (null !== $invoice->getCode()) {
            return;
        }

        $amount = [];
        $amountTax = [];

        foreach ($invoice->getJobs() as $job) {
            $service = $job->getService();

            $job->setAmount($service->getAmount());
            $job->setTax($service->hasTax());
            $job->setTaxRate($service->getTaxRate());

            $amount[] = $job->getQuantity() * $job->getAmount();
            $amountTax[] = $job->hasTax() ? $job->getQuantity() * $job->getAmount() * $job->getTaxRate() : 0;
        }

        $customer = $invoice->getCustomer();

        $invoice->setAmount(array_sum($amount));
        $invoice->setAmountTax(array_sum($amountTax));
        $invoice->setData([
            'name' => $customer->getName(),
            'contact' => $customer->getContact(),
            'address' => $customer->getAddress(),
            'zipcode' => $customer->getZipcode(),
            'city' => $customer->getCity(),
            'country' => $customer->getCountry(),
        ]);
    }
}
