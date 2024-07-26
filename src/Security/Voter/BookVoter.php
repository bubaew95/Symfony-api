<?php

namespace App\Security\Voter;

use App\Entity\Book;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BookVoter extends Voter
{
    public const EDIT = 'EDIT';

    public function __construct(private readonly Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::EDIT === $attribute && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        assert($subject instanceof Book);

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if (self::EDIT === $attribute) {
            if (!$this->security->isGranted('ROLE_BOOK_EDIT')) {
                return false;
            }
            if ($subject->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
