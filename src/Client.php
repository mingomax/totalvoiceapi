<?php
declare(strict_types=1);

namespace Dteruel;

/**
 * Interface Client
 * @package Dteruel
 *
 * @author Domingos Teruel <mingomax@dteruel.net.br>
 */
interface Client
{
    /**
     * @param string $message
     * @param string $to
     * Send a single SMS Message
     */
    public function sendSms(string $message, string $to);
}
