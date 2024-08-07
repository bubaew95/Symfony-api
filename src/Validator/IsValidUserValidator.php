<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidUserValidator extends ConstraintValidator
{
    public function __construct(private readonly Security $security)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        assert($constraint instanceof IsValidUser);

        if (null === $value || '' === $value) {
            return;
        }

        assert($value instanceof User);

        $user = $this->security->getUser();
        if (!$user instanceof UserInterface) {
            throw new \LogicException('IsUserValidator should only be used when a user is logged in.');
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        if ($value !== $user) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
