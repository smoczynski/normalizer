<?php

namespace App\Normalizer\Base;

use App\Entity\Base\EntityInterface;

interface NormalizerInterface
{
    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function normalize(EntityInterface $entity): array;

    /**
     * @param $object
     * @return bool
     */
    public function supports($object): bool;
}
