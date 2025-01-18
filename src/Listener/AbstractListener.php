<?php

declare(strict_types=1);

namespace Spyck\AccountingBundle\Listener;

use Exception;
use Spyck\AccountingBundle\Entity\Invoice;

abstract class AbstractListener
{
    protected function patchInvoice(Invoice $invoice): void
    {
        $amount = 0.0;
        $amountTax = 0.0;

        foreach ($invoice->getJobs() as $job) {
            $service = $job->getService();

            $job->setTax($service->hasTax());
            $job->setTaxRate($service->getTaxRate());

            $amount += round($job->getQuantity() * $job->getAmount(), 2);
            $amountTax += $job->hasTax() ? round($job->getQuantity() * $job->getAmount() * $job->getTaxRate(), 2) : 0;
        }

        if (null !== $invoice->getCode()) {
            if ($amount !== $invoice->getAmount() || $amountTax !== $invoice->getAmountTax()) {
                throw new Exception('Invoice closed');
            }
        }

        $customer = $invoice->getCustomer();

        $invoice->setAmount($amount);
        $invoice->setAmountTax($amountTax);
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
