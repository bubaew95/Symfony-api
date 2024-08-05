<?php

namespace App\Validator;

use App\Entity\Book;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BooksAllowedUserChangeValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BooksAllowedUserChange $constraint */
        if (null === $value || '' === $value) {
            return;
        }
        /* @var Collection $value */
        $unitOfWork = $this->entityManager->getUnitOfWork();
        foreach ($value as $book) {
            /** @var Book $book */
            $originData = $unitOfWork->getOriginalEntityData($book);
            $originUserId = $originData['user_id'];
            $newUserId = $book->getUser()->getId();

            if (!$originUserId || $originUserId === $newUserId) {
                return;
            }

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
