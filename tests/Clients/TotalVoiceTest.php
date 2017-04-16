<?php
declare(strict_types=1);

namespace Dteruel\Clients;

use PHPUnit\Framework\TestCase;

/**
 * Class TotalVoiceTest
 * @package Dteruel\Clients
 *
 * @author Domingos Teruel <mingomax@dteruel.net.br>
 */
class TotalVoiceTest extends TestCase
{
    /**
     * @var TotalVoice
     */
    private $totalVoiceClient;

    /**
     * @before
     */
    public function configure()
    {
        global $mockSocketCreate;
        $mockSocketCreate = false;
        $this->totalVoiceClient = new TotalVoice('APIKEY');
    }

    /**
     * @test
     *
     * @covers \Dteruel\Clients\TotalVoice::__construct
     */
    public function shouldInstantiateANewClient()
    {
        $totalVoiceClient = new TotalVoice('APIKEY');

        $this->assertAttributeContains('APIKEY', 'authorization', $totalVoiceClient);
    }

    /**
     * @test
     *
     * @covers \Dteruel\Clients\TotalVoice::sendSms
     * @covers \Dteruel\Clients\TotalVoice::sendRequest
     * @covers \Dteruel\Clients\TotalVoice::initialize
     * @covers \Dteruel\Clients\TotalVoice::connect
     * @covers \Dteruel\Clients\TotalVoice::canSocketWrite
     * @covers \Dteruel\Clients\TotalVoice::readResponse
     * @covers \Dteruel\Clients\TotalVoice::close
     * @covers \Dteruel\Clients\TotalVoice::createPostRequest
     */
    public function shouldSendASMSMessage()
    {
        $data = $this->totalVoiceClient->sendSms('message', '11999999999');
        $this->assertTrue(is_string($data));
    }

    /**
     * @test
     *
     * @covers \Dteruel\Clients\TotalVoice::sendSms
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Your message should be between 1 and 160 characters.
     */
    public function shouldRaiseAnExceptionWhenTheMessageIsShort()
    {
        $this->totalVoiceClient->sendSms('', '11999999999');
    }

    /**
     * @test
     *
     * @covers \Dteruel\Clients\TotalVoice::sendSms
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Your phone number means is invalid. use: 99999999999
     */
    public function shouldRaiseAnExceptionWhenThePhoneNumerIsInvalid()
    {

        $this->totalVoiceClient->sendSms('my great message', '1199999999');
    }
}
