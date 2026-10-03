<?php

namespace Jalle19\HsDebaiter\HsApi;

use Jalle19\HsDebaiter\Model\Article;
use Nyholm\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

function isLiveArticle(array $item): bool
{
    // There's also an isLive boolean but that one changes to false when reporting ends, and we don't want to change
    // the status to reflect that
    return isset($item['liveArticle']);
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
     * @throws HsApiException
     */
    public function getLaneItems(Article $article): array
    {
        $url = sprintf("%s/laneitems/%d", self::API_BASE_URL, $article->getNumericalGuid());

        $response = $this->httpClient->sendRequest(new Request('GET', $url));

        if ($response->getStatusCode() !== 200) {
            // Distinguish between "article not found" and other errors
            if ($response->getStatusCode() === 404) {
                throw new ArticleNotFoundException();
            } else {
                throw new HsApiException('Got bad response from HS API: ' . $response->getStatusCode());
            }
        }

        return \json_decode($response->getBody()->getContents(), true);
    }
}
