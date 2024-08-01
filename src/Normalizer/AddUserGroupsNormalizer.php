<?php

namespace App\Normalizer;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsDecorator('api_platform.jsonld.normalizer.item')]
class AddUserGroupsNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    public function __construct(private readonly NormalizerInterface $normalizer)
    {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        //        dump('IT WORKS');

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->normalizer->getSupportedTypes($format);
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->normalizer instanceof SerializerAwareInterface) {
            $this->normalizer->setSerializer($serializer);
        }
    }
}
