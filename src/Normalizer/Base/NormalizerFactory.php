<?php

namespace App\Normalizer\Base;

use App\Exception\NotNormalizableValueException;
use App\Normalizer\CategoryNormalizer;
use App\Normalizer\CourseNormalizer;
use App\Normalizer\LanguageNormalizer;
use App\Normalizer\UserNormalizer;

class NormalizerFactory
{
    /**
     * @var array
     */
    private $normalizers;

    /**
     * NormalizerFactory constructor.
     * @param UserNormalizer $userNormalizer
     * @param CategoryNormalizer $categoryNormalizer
     * @param CourseNormalizer $courseNormalizer
     * @param LanguageNormalizer $languageNormalizer
     */
    public function __construct(
        UserNormalizer $userNormalizer,
        CategoryNormalizer $categoryNormalizer,
        CourseNormalizer $courseNormalizer,
        LanguageNormalizer $languageNormalizer
    )
    {
        $this->normalizers[] = $userNormalizer;
        $this->normalizers[] = $categoryNormalizer;
        $this->normalizers[] = $courseNormalizer;
        $this->normalizers[] = $languageNormalizer;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function normalize($data)
    {
        $normalizer = $this->getNormalizer($data);

        if (is_array($data) || $data instanceof \Traversable) {
            $normalized = [];
            foreach ($data as $key => $val) {
                $normalized[$key] = $this->normalize($val);
            }

            return $normalized;
        }

        if ($normalizer) {
            return $this->normalize(
                $normalizer->normalize($data)
            );
        }

        if (null === $data || is_scalar($data)) {
            return $data;
        }

        throw new NotNormalizableValueException(
            is_object($data) ?
                sprintf(
                    'Could not normalize object of type %s, no supporting normalizer found.',
                    get_class($data)
                ) :
                sprintf(
                    'An unexpected value could not be normalized: %s',
                    var_export($data, true)
                )
        );
    }

    /**
     * @param $data
     * @return NormalizerInterface|null
     */
    private function getNormalizer($data): ?NormalizerInterface
    {
        if (!is_object($data)) {
            return null;
        }

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($data)) {
                return $normalizer;
            }
        }

        return null;
    }
}
