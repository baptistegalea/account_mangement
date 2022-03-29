<?php

declare(strict_types=1);

namespace App\DoTheSums\Shared\Presentation\Http\Symfony\ArgumentValueResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class HttpInputResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $fqcn = (string)$argument->getType();

        return (str_contains($fqcn, 'Presentation\\Http\\') && str_ends_with($fqcn, 'Input'));
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);

        yield $serializer->deserialize(
            $request->getContent(),
            (string)$argument->getType(),
            'json'
        );
    }
}
