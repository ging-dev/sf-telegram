<?php

use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    return $framework->serializer()
        ->defaultContext(AbstractObjectNormalizer::SKIP_NULL_VALUES, true)
        ->enableAnnotations(true)
    ;
};
