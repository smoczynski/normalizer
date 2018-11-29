<?php

namespace App\Normalizer;

use App\Entity\Base\EntityInterface;
use App\Entity\Language;
use App\Normalizer\Base\NormalizerInterface;

class LanguageNormalizer implements NormalizerInterface
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
     * @param Language $entity
     * @return array
     */
    public function normalize(EntityInterface $entity): array
    {
        return [
            'name' => $entity->getName(),
            'code' => $entity->getCode(),
            'path' => $this->projectDir . "/some-path",
        ];
    }

    /**
     * @param $object
     * @return bool
     */
    public function supports($object): bool
    {
        return $object instanceof Language;
    }
}
