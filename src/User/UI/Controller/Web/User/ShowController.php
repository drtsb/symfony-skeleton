<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\User\Query\Show\ShowQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class ShowController extends AbstractController
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    #[Route('/user/show', name: 'user.show', methods: ['GET'])]
    public function __invoke(string $id): Response
    {
        $envelope = $this->queryBus->dispatch(new ShowQuery($id));

        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);

        return $this->render(
            'user/user/show.html.twig',
            [
                'user' => $handled->getResult(),
            ]
        );
    }
}
