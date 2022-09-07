<?php

namespace spec\Genesis\API\Request\Financial\SDD;

use Genesis\API\Request\Financial\SDD\Sale;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class SaleSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Sale::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount',
            'currency',
            'billing_country',
            'iban'
        ]);
    }

    public function it_should_fail_when_missing_sdd_bank_parameters()
    {
        $this->setBaseRequestParameters();
        $this->shouldThrow()->during('getDocument');
    }

    protected function setBaseRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis Automated PHP Request');
        $this->setRemoteIp($faker->ipv4);

        $this->setCurrency(
            $faker->randomElement(
                \Genesis\Utils\Currency::getList()
            )
        );
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $this->setCustomerEmail($faker->email);
    }

    protected function setSDDRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setIban($faker->iban('DE'));
        $this->setBic('PBNKDEFFXXX');
    }

    protected function setBillingInfoRequestParams()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingCountry('DE');
    }

    protected function setRequestParameters()
    {
        $this->setBaseRequestParameters();
        $this->setSDDRequestParameters();
        $this->setBillingInfoRequestParams();
    }
}