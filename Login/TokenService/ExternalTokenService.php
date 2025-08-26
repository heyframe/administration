<?php declare(strict_types=1);

namespace HeyFrame\Administration\Login\TokenService;

use HeyFrame\Administration\Login\Config\LoginConfig;
use HeyFrame\Administration\Login\Config\LoginConfigService;
use HeyFrame\Administration\Login\LoginException;
use HeyFrame\Core\Framework\Log\Package;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @internal
 */
#[Package('framework')]
final readonly class ExternalTokenService
{
    public function __construct(
        private HttpClientInterface $client,
        private LoginConfigService $loginConfigService,
    ) {
    }

    public function getUserToken(string $code): TokenResult
    {
        $loginConfig = $this->loginConfigService->getConfig();
        if (!$loginConfig instanceof LoginConfig) {
            throw LoginException::configurationNotFound();
        }

        $tokenResponse = $this->client->request('POST', $loginConfig->baseUrl . $loginConfig->tokenPath, [
            'body' => [
                'grant_type' => 'authorization_code',
                'scope' => $loginConfig->scope,
                'client_id' => $loginConfig->clientId,
                'client_secret' => $loginConfig->clientSecret,
                'code' => $code,
                'redirect_uri' => $loginConfig->redirectUri,
            ],
        ]);

        return TokenResult::createFromResponse($tokenResponse->getContent());
    }
}
