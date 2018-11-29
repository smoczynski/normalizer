<?php

namespace App\Normalizer;

use App\Entity\Base\EntityInterface;
use App\Entity\User;
use App\Normalizer\Base\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /**
     * @var string
     */
    private  $projectDir;

    /**
     * CategoryNormalizer constructor.
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param User $entity
     * @return array
     */
    public function normalize(EntityInterface $entity): array
    {
        return [
            'id' => $entity->getId(),
            'firstName' => $entity->getFirstName(),
            'lastName' => $entity->getLastName(),
            'fullName' => $entity->getFirstName() . ' ' . $entity->getLastName(),
            'birthDate' => $entity->getBirthDate() ? $entity->getBirthDate()->format('Y-m-d') : '-',
            'language' => $entity->getLanguage(),
            'address' => "{$entity->getCity()}, {$entity->getStreetName()}",
            'course' => $entity->getCourse(),
            'path' => $this->projectDir . "/some-path",
        ];
    }

    /**
     * @param $object
     * @return bool
     */
    public function supports($object): bool
    {
        return $object instanceof User;
    }
}
