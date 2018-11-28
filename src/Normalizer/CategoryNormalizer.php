<?php

namespace App\Normalizer;

use App\Entity\Base\EntityInterface;
use App\Entity\Category;
use App\Normalizer\Base\NormalizerInterface;

class CategoryNormalizer implements NormalizerInterface
{
    /**
     * @param Category $entity
     * @return array
     */
    public function normalize(EntityInterface $entity): array
    {
        return [
            'name' => $entity->getName(),
        ];
    }

    /**
     * @param $object
     * @return bool
     */
    public function supports($object): bool
    {
        return $object instanceof Category;
    }
}
