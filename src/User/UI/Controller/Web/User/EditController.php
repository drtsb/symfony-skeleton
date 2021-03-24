<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\Command\User\Edit\EditCommand;
use App\User\Application\Command\User\Edit\EditForm;
use App\User\Domain\Aggregate\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class EditController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws LogicException
     */
    #[Route('/user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, User $user): Response
    {
        $command = EditCommand::createFromUser($user);
        $form = $this->createForm(EditForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('user.index');
        }

        return $this->render(
            'user/user/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
