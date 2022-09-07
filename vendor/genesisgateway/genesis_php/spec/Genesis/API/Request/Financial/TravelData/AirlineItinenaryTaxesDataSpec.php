<?php


namespace spec\Genesis\API\Request\Financial\TravelData;

use Genesis\API\Request\Financial\TravelData\AirlineItineraryTaxesData;
use Genesis\API\Request\Financial\TravelData\AdditionalAidAttributes;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;


class AirlineItineraryTaxesDataSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith(1,'Testexam');
    }

    function it_should_be_instance_of_base_airline_itinenary_class()
    {
        $this->shouldBeAnInstanceOf(AdditionalAidAttributes::class);
    }

    public function it_should_fail_when_fee_type_is_more_than_eight_symbols()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setFeeType', ['Aabbccddff']);
    }

    public function it_should_not_throw_with_maximum_eight_symbols()
    {
        $this->shouldNotThrow(InvalidArgument::class)->during('setFeeType', ['Aabbccdd']);
    }
}
