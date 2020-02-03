<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter {
	protected function supports($attribute, $subject) {
		return in_array($attribute, ['MANAGE'])
			&& $subject instanceof Article;
	}

	protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
		/** @var Article $subject */
		$user = $token->getUser();
		// if the user is anonymous, do not grant access
		if (!$user instanceof UserInterface) {
			return false;
		}

		// ... (check conditions and return true to grant permission) ...
		switch ($attribute) {
			case 'MANAGE':
				// this is the author
				if($subject->getAuthor() == $user){
					return true;
				}
				break;
		}

		return false;
	}
}
