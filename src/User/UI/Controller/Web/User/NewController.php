<?php

declare(strict_types=1);

namespace App\User\UI\Controller\Web\User;

use App\User\Application\Command\User\Create\CreateCommand;
use App\User\Application\Command\User\Create\CreateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class NewController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    /**
     * @param Request $request
     * @return Response
     * @throws LogicException
     */
    #[Route('/user/new', name: 'user.new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $command = new CreateCommand();
        $form = $this->createForm(CreateForm::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('user.index');
        }

        return $this->render(
            'user/user/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
