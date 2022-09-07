<?php

namespace spec\Genesis\API\Constants\NonFinancial\Fraud\Chargeback;

use Genesis\API\Constants\NonFinancial\Fraud\Chargeback\ProcessingTypes;
use PhpSpec\ObjectBehavior;

/**
 * Class ProcessingTypesSpec
 * @package spec\Genesis\API\Constants\NonFinancial\Fraud\Chargeback
 */
class ProcessingTypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ProcessingTypes::class);
    }

    public function it_should_be_array_get_all_processing_types()
    {
        $this->getAll()->shouldBeArray();
    }
}
