<?php declare(strict_types=1);

namespace HeyFrame\Administration\Login;

use HeyFrame\Administration\Login\TokenService\ExternalTokenService;
use HeyFrame\Administration\Login\UserService\ExternalAuthUser;
use HeyFrame\Administration\Login\UserService\UserService;
use HeyFrame\Core\Framework\Log\Package;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\RequestAccessTokenEvent;
use League\OAuth2\Server\RequestEvent;
use League\OAuth2\Server\RequestRefreshTokenEvent;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @internal
 */
#[Package('framework')]
class HeyFrameGrantType extends AbstractGrant
{
    public const TYPE = 'heyframe_grant';

    public function __construct(
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        private readonly UserService $userService,
        private readonly ExternalTokenService $tokenService,
    ) {
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function getIdentifier(): string
    {
        return self::TYPE;
    }

    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseTypeInterface $responseType, \DateInterval $accessTokenTTL): ResponseTypeInterface
    {
        $client = $this->getClientEntityOrFail('administration', $request);
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request, $this->defaultScope));

        $userIdentifier = $this->validateUser($request)->getIdentifier();

        $finalizedScopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client, $userIdentifier);

        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $userIdentifier, $finalizedScopes);
        $this->getEmitter()->emit(new RequestAccessTokenEvent(RequestEvent::ACCESS_TOKEN_ISSUED, $request, $accessToken));
        $responseType->setAccessToken($accessToken);

        $refreshToken = $this->issueRefreshToken($accessToken);

        if ($refreshToken !== null) {
            $this->getEmitter()->emit(new RequestRefreshTokenEvent(RequestEvent::REFRESH_TOKEN_ISSUED, $request, $refreshToken));
            $responseType->setRefreshToken($refreshToken);
        }

        return $responseType;
    }

    private function validateUser(ServerRequestInterface $request): ExternalAuthUser
    {
        $code = $this->getRequestParameter('code', $request);
        if ($code === null) {
            throw LoginException::noCodeProvided();
        }

        try {
            $token = $this->tokenService->getUserToken($code);
            $user = $this->userService->getAndUpdateUser($token);
        } catch (\Throwable $exception) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw $exception;
        }

        return $user;
    }
}
