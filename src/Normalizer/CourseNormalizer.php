<?php

namespace App\Normalizer;

use App\Entity\Base\EntityInterface;
use App\Entity\Course;
use App\Normalizer\Base\NormalizerInterface;

class CourseNormalizer implements NormalizerInterface
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
     * @param Course $entity
     * @return array
     */
    public function normalize(EntityInterface $entity): array
    {
        return [
            'name' => $entity->getName(),
            'isPublished' => $entity->isPublished(),
            'createdAt' => $entity->getCreatedAt()->format('Y-m-d'),
            'updatedAt' => $entity->getUpdatedAt() ? $entity->getUpdatedAt()->format('Y-m-d') : '-',
            'category' => $entity->getCategory(),
            'language' => $entity->getLanguage()->getCode(),
            'path' => $this->projectDir . "/some-path"
        ];
    }

    /**
     * @param $object
     * @return bool
     */
    public function supports($object): bool
    {
        return $object instanceof Course;
    }
}
