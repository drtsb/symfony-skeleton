<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\Command\User\Delete\DeleteCommand;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @param string $id
     * @param Request $request
     * @return Response
     * @throws LogicException
     */
    #[Route('/user/{id}', name: 'user.delete', methods: ['DELETE'])]
    public function __invoke(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->commandBus->dispatch(new DeleteCommand($id));
        }

        return $this->redirectToRoute('user.index');
    }
}
