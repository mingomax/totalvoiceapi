<?php
declare(strict_types=1);

namespace Dteruel\Clients;

use Dteruel\Client;
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
     * @var Client
     */
    private $client;

    /**
     * @before
     */
    public function configure()
    {
        $this->client = new TotalVoice('apikey');
    }

    /**
     * @test
     */
    public function shouldInstantiateANewClient()
    {
        $totalVoiceClient = new TotalVoice('APIKEY');

        $this->assertAttributeContains('APIKEY', 'authorization', $totalVoiceClient);
    }
}
