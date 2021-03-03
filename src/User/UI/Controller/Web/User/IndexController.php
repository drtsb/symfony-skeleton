<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\User\Query\Index\IndexQuery;
use App\User\Application\User\Query\Index\IndexQueryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    #[Route('/user/index', name: 'user.index', methods: ['GET'])]
    public function __invoke(): Response
    {
        $envelope = $this->queryBus->dispatch(new IndexQuery());

        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);

        /** @var IndexQueryDto $result */
        $result = $handled->getResult();

        return $this->render(
            'user/user/index.html.twig',
            [
                'users' => $result->users,
            ]
        );
    }
}
