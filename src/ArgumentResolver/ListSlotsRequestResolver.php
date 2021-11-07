<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\ValueObject\ListSlotsRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ListSlotsRequestResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (ListSlotsRequest::class !== $argument->getType()) {
            return false;
        }
        return true;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            yield new ListSlotsRequest(
                $request->get('sortType'),
                new \DateTime($request->get('dateFrom')),
                new \DateTime($request->get('dateTo')),
            );
        } catch (\TypeError $error) {
            // TODO: Do not show off everything just like that
            throw new BadRequestHttpException($error->getMessage());
        }
    }
}
