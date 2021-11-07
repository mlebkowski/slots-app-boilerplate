<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\SortingMethodNotFound;
use App\Service\SortedSlotsProvider;
use App\ValueObject\ListSlotsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class SlotsController extends AbstractController
{
    private SortedSlotsProvider $slotsProvider;
    private SerializerInterface $serializer;

    public function __construct(SortedSlotsProvider $slotsProvider, SerializerInterface $serializer)
    {
        $this->slotsProvider = $slotsProvider;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/slots", name="slots", methods={"GET"})
     */
    public function list(ListSlotsRequest $request): Response
    {
        try {
            $slots = $this->slotsProvider->getSortedSlotsFromTimeframe(
                $request->getDateFrom(),
                $request->getDateTo(),
                $request->getSortType()
            );
        } catch (SortingMethodNotFound $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return new Response($this->serializer->serialize($slots->getSlots(), 'json'));
    }
}
