<?php

namespace Jalle19\HsDebaiter\HsApi;

use Jalle19\HsDebaiter\Model\Article;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

function isLiveArticle(array $item): bool
{
    return isset($item['liveArticle']) && $item['liveArticle']['isLive'] === true;
}

class HsApiService
{
    private const string API_BASE_URL = 'https://www.hs.fi/api';

    private ClientInterface $httpClient;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getLaneItems(Article $article): array
    {
        $url = sprintf("%s/laneitems/%d", self::API_BASE_URL, $article->getNumericalGuid());

        $response = $this->httpClient->sendRequest(new Request('GET', $url));

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Got bad response from HS API: ' . $response->getStatusCode());
        }

        return \json_decode($response->getBody()->getContents(), true);
    }
}
