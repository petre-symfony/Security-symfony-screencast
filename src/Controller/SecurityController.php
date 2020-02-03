<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
	/**
	 * @Route("/login", name="app_login")
	 */
	public function login(AuthenticationUtils $authenticationUtils):Response {
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		return $this->render('security/login.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error
		]);
	}
	
	/**
	 * @Route("/logout", name="app_logout")
	 */
	public function logout(){
		throw new \Exception('Will be intercepted before getting here');
	}
	
	/**
	 * @Route("/register", name="app_register")
	 */
	public function register(
		Request $request,
		UserPasswordEncoderInterface $passwordEncoder,
		EntityManagerInterface $em
	){
		if($request->isMethod('POST')){
			$user = new User();
			$user->setEmail($request->request->get('email'));
			$user->setFirstName('Mystery');
			$user->setPassword($passwordEncoder->encodePassword(
				$user,
				$request->request->get('password')
			));
			
			$em->persist($user);
			$em->flush();
			
			return $this->redirectToRoute('app_account');
		}
		
		return $this->render('security/register.html.twig');
	}
}
