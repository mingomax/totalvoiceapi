<?php
declare(strict_types=1);

namespace Dteruel\Clients;

use Dteruel\Client;
use Dteruel\HttpConnectionException;

/**
 * Class TotalVoice
 * @package Dteruel\Clients
 *
 * @author Domingos Teruel <mingomax@dteruel.net.br>
 */
class TotalVoice implements Client
{
    const API_URL = "https://api.totalvoice.com.br";

    /**
     * @var string
     * API Authorization (access token or API key)
     */
    private $authorization;

    /**
     * @var string
     * API base url
     */
    private $apiUrl;

    /**
     * @var resource
     */
    private $socket;

    /**
     * TotalVoice constructor.
     * @param string $authorization
     */
    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @param string $message
     * @param string $to
     * @return array|mixed
     * @throws \InvalidArgumentException
     */
    public function sendSms(string $message, string $to)
    {
        if (strlen($message) < 1|| strlen($message) > 160) {
            throw new \InvalidArgumentException("Your message should be between 1 and 160 characters.");
        }

        if (strlen($to) !== 11) {
            throw new \InvalidArgumentException("Your phone number means is invalid. use: 99999999999");
        }

        return $this->sendRequest(
            '/sms',
            'POST',
            [
                "numero_destino" => $to,
                'mensagem' => $message,
            ]
        );
    }

    /**
     * @param string $path
     * @param string $method
     * @param array|null $data
     * @return array|mixed
     * @throws HttpConnectionException
     */
    private function sendRequest(string $path, string $method, array $data = null)
    {
        $this->initialize();
        $this->connect();
        $request = $this->createPostRequest($path, $method, $data);

        if (!$this->canSocketWrite($request)) {
            throw new HttpConnectionException(sprintf(
                "Request can't send, reason: %s",
                socket_strerror(socket_last_error($this->socket))
            ));
        };

        $response = $this->readResponse();
        $this->close();

        return $response;
    }

    /**
     * Configure and initialize the socket stream.
     */
    private function initialize()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if (!$this->socket) {
            throw new \RuntimeException(sprintf(
                "Socket failed. Reason: %s",
                socket_strerror(socket_last_error($this->socket))
            ));
        }
    }

    /**
     * Coonect to address
     * @throws HttpConnectionException
     */
    private function connect()
    {
        $parsedUrl = parse_url(self::API_URL);
        $service_port = getservbyname('www', 'tcp');
        $this->apiUrl = gethostbyname($parsedUrl["host"]);
        $conn = socket_connect($this->socket, $this->apiUrl, $service_port);

        if (!$conn) {
            throw new HttpConnectionException(sprintf(
                "Connection failed: %s",
                socket_strerror(socket_last_error($this->socket))
            ));
        }
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @return string
     */
    private function createPostRequest(string $path, string $method, array $data): string
    {
        $method = strtoupper($method);
        $data = json_encode($data);
        $length = strlen($data);

        $request = "$method $path HTTP/1.1\r\n";
        $request .= "Content-Type: application/json\r\n";
        $request .= "Access-Token: 288d34719e3013e77136311eccb01068\r\n";
        $request .= "Accept: application/json\r\n";
        $request .= "Host: {$this->apiUrl}\r\n";
        $request .= "Connection: close\r\n";
        $request .= "User-Agent: Dteruel/PHP\r\n";
        $request .= "Content-Length: $length\r\n\r\n";
        $request .= "$data";
        $request .= "\r\n\r\n";

        return $request;
    }

    /**
     * Close Socket Connection
     */
    private function close()
    {
        socket_close($this->socket);
    }

    /**
     * @param $request
     * @return bool
     */
    private function canSocketWrite($request): bool
    {
        if (socket_write($this->socket, $request, strlen($request)) === false) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     * @throws HttpConnectionException
     */
    private function readResponse(): string
    {
        if (!($response = socket_read($this->socket, 1024, MSG_WAITALL))) {
            throw new HttpConnectionException(sprintf(
                "Can't read response. Reason: %s",
                socket_strerror(socket_last_error($this->socket))
            ));
        }
        return $response;
    }
}
