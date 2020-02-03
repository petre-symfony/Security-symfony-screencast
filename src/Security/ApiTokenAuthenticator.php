<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator {
	/**
	 * @var ApiTokenRepository
	 */
	private $tokenRepository;
	
	public function __construct(ApiTokenRepository $tokenRepository) {
		$this->tokenRepository = $tokenRepository;
	}
	
	public function supports(Request $request) {
		return $request->headers->has('Authorization')
			&& 0 === strpos($request->headers->get('Authorization'), 'Bearer ');
	}

	public function getCredentials(Request $request) {
		$authorizationHeader = $request->headers->get('Authorization');
		
		//skip beyond Bearer
		return substr($authorizationHeader, 7);
	}

	public function getUser($credentials, UserProviderInterface $userProvider) {
		$token = $this->tokenRepository->findOneBy([
			'token' => $credentials
		]);
		
		if(!$token){
			throw new CustomUserMessageAuthenticationException('Invalid API token');
		}
		
		return $token->getUser();
	}

	public function checkCredentials($credentials, UserInterface $user) {
		dd('checking credentials');
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
		return new JsonResponse([
			'message' => $exception->getMessageKey()
		], 401);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
		// todo
	}

	public function start(Request $request, AuthenticationException $authException = null) {
		// todo
	}

	public function supportsRememberMe() {
		// todo
	}
}
