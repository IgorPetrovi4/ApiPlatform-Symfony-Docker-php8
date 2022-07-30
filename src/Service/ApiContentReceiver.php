<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiContentReceiver
{
    private string $api_url;

    public function __construct(
        private readonly ?HttpClientInterface $client,
        private readonly string $file_path
    ){}

    public function getApiContent(string $api_url): string
    {
        $this->setApiUrl($api_url);
        $result = [];
        $page = 1;
        while (true) {
            $response = $this->client->request('GET', $this->getUrl() . $page);

            if (200 !== $response->getStatusCode()) {
                throw new \Exception('Error Api Code - ' . $response->getStatusCode());
            }

            if (!empty($response->toArray())) {
                foreach ($response->toArray() as $value) {
                    $result[] = $value;
                }
                $page++;
            } else {
                break;
            }
        }
        $this->addFile($result);
        return json_encode($result);
    }

    public function getApiUrl(): string
    {
        return $this->api_url;
    }

    public function setApiUrl(string $api_url): self
    {
        $this->api_url = $api_url;
        return $this;
    }

    public function getUrl():string
    {
        return $this->getApiUrlShema() . '://' . $this->getApiUrlHost() . $this->getApiUrlPath() . '?page=';
    }

    public function getApiUrlHost():string
    {
        return parse_url($this->getApiUrl(), PHP_URL_HOST);
    }

    public function getApiUrlPath(): string
    {
        return parse_url($this->getApiUrl(), PHP_URL_PATH);
    }

    public function getApiUrlShema():string
    {
        return parse_url($this->getApiUrl(), PHP_URL_SCHEME);
    }

    public function addFile($result): void
    {
        $fileHandler = fopen($this->file_path . $this->getApiUrlPath() . '.json', 'w');
        fwrite($fileHandler, json_encode($result,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function getfilePath():string
    {
        return $this->getApiUrlShema() . '://' . $this->getApiUrlHost().'/'.explode('/', $this->file_path)[1] . $this->getApiUrlPath() . '.json';
    }

}
