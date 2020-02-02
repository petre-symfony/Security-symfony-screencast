<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator {
	public function supports(Request $request) {
		return $request->attributes->get('_route') === 'app_login'
			&& $request->isMethod('POST');
	}
	
	public function getCredentials(Request $request) {
		dd($request->request->all());
	}
	public function getUser($credentials, UserProviderInterface $userProvider) {
		// todo
	}
	
	public function checkCredentials($credentials, UserInterface $user) {
		// todo
	}
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {
		// todo
	}
	
	protected function getLoginUrl() {
		// TODO: Implement getLoginUrl() method.
	}
}