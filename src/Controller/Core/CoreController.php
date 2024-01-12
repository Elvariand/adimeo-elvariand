<?php

namespace App\Controller\Core;

use App\Entity\Picture;
use Google\Client as Google_Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

require_once '/var/www/vendor/autoload.php';

class CoreController extends AbstractController
{
    #[Route('/apod', name: 'apod')]
    public function apod(EntityManagerInterface $entityManager): Response
    {
        isset($_SESSION) ?: session_start();

        // si on ne vient pas suite à l'authentification google et qu'on n'est pas déjà connecté, on repart vers le login
        if ((!isset($_POST) || count($_POST) == 0) && !isset($_SESSION['identified'])) {
            return $this->redirectToRoute('login', [
                "message" => '0'
            ]);
        }

        // On va chercher dans la BDD la photo la plus récente, c'est normalement la dernière ajoutée à la table on va chercher également l'ensemble de la table pour la mettre dans la sidebar
        $picRepo = $entityManager->getRepository(Picture::class);
        $lastPic = $picRepo->findBy([],['id' => 'DESC'],1,0)[0];
        $pics = $picRepo->findAll();

        // Génération de la page si l'on arrive dessus alors que l'on est déjà identifié
        if (isset($_SESSION['identified'])) {

            return $this->render('apod.html.twig', [
                "copyright" => $lastPic->getCopyright(),
                "date" => $lastPic->getDate(),
                "title" => $lastPic->getTitle(),
                "explanation" => $lastPic->getExplanation(),
                "media_type" => $lastPic->getMediaType(),
                "hdpath" => $lastPic->getHdpath(),
                "path" => $lastPic->getPath(),
                "identified" => $_SESSION['identified'],
                "allPics" => $pics,
            ]);
        }

        // Get $id_token via HTTPS POST.
        $client = new Google_Client(['client_id' => '784533552460-njfvl5gari0nson4ua24o36on6t166kd.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($_POST['credential']);

        // Génération de la page si l'on arrive dessus alors que l'on vient de s'identifier par Google
        if ($payload) {

            $_SESSION['identified'] = $payload['sub'];

            return $this->render('apod.html.twig', [
                "copyright" => $lastPic->getCopyright(),
                "date" => $lastPic->getDate(),
                "title" => $lastPic->getTitle(),
                "explanation" => $lastPic->getExplanation(),
                "media_type" => $lastPic->getMediaType(),
                "hdpath" => $lastPic->getHdpath(),
                "path" => $lastPic->getPath(),
                "identified" => $_SESSION['identified'],
                "allPics" => $pics,
            ]);
        } else {
            // Si l'ID du jeton n'est pas bon
            return $this->redirectToRoute('login', [
                "message" => '1'
            ]);
        }
    }


    // C'est la même fonction qu'au-dessus à ceci près que l'on demande une photo d'une date précise
    #[Route('/apod/{date}', name: 'old_apod')]
    public function oldApod(EntityManagerInterface $entityManager, string $date): Response
    {
        // si on ne vient pas suite à l'authentification google et qu'on n'est pas déjà connecté, on repart vers le login
        isset($_SESSION) ?: session_start();
        if ((!isset($_POST) || count($_POST) == 0) && !isset($_SESSION['identified'])) {
            return $this->redirectToRoute('login', [
                "message" => '0'
            ]);
        }

        // On va chercher dans la BDD la photo demandée, on va chercher également l'ensemble de la table pour la mettre dans la sidebar
        $picRepo = $entityManager->getRepository(Picture::class);
        $pic = $picRepo->findOneBy(['date' => $date]);
        $pics = $picRepo->findBy([], ['id' => "DESC"]);

        // Génération de la page si l'on arrive dessus alors que l'on est déjà identifié
        if (isset($_SESSION['identified'])) {

            return $this->render('oldApod.html.twig', [
                "copyright" => $pic->getCopyright(),
                "date" => $pic->getDate(),
                "title" => $pic->getTitle(),
                "explanation" => $pic->getExplanation(),
                "media_type" => $pic->getMediaType(),
                "hdpath" => $pic->getHdpath(),
                "path" => $pic->getPath(),
                "identified" => $_SESSION['identified'],
                "allPics" => $pics,
            ]);

        } else {

            // Si pour une raison quelconque l'utilisateur arrive ici sans être identifié
            return $this->redirectToRoute('login', [
                "message" => '1'
            ]);
        }
    }
}
