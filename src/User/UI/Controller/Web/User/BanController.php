<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\User\Command\Ban\BanCommand;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class BanController extends AbstractController
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
    #[Route('/user/{id}/ban', name: 'user.ban', methods: ['POST'])]
    public function ban(string $id, Request $request): Response
    {
        if ($this->isCsrfTokenValid('ban' . $id, $request->request->get('_token'))) {
            $this->commandBus->dispatch(BanCommand::create($id));
        }

        return $this->redirectToRoute('user.index');
    }
}
