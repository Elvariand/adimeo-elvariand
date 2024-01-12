<?php

namespace App\Controller;

use App\Message\FetchApodMessage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// C'est avec ce controller que l'on execute la commande de mise à jour de la BDD automatiquement chaque jour

#[Route('/fetchapod')]
class fetchApodController extends AbstractController
{

    #[Route("/", name: 'fetchapod')]
    public function fetchApod(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new FetchApodMessage());

        return $this->redirectToRoute('apod');
    }
}
