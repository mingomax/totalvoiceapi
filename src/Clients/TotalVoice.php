<?php
declare(strict_types=1);

namespace Dteruel\Clients;

use Dteruel\Client;

/**
 * Class TotalVoice
 * @package Dteruel\Clients
 *
 * @author Domingos Teruel <mingomax@dteruel.net.br>
 */
class TotalVoice implements Client
{
    /**
     * @var string
     * API Authorization (access token or API key)
     */
    private $authorization;

    /**
     * TotalVoice constructor.
     * @param string $authorization
     */
    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
    }


}