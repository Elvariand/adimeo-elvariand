<?php

namespace App\Controller\Index;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        // On demarre la session et on part sur la page de login
        session_start();
        return $this->redirectToRoute('login');
    }

    #[Route('/login', name: 'login')]
    public function login($message = null)
    {
        isset($_SESSION) ?: session_start();
        $identified = isset($_SESSION['identified']) ? true : false;

        // Génération des différents messages d'erreur de connexion
        if (isset($_GET['message'])) {
            switch ($_GET['message']) {
                case '0':
                    $message = 'Merci de bien vouloir vous connecter avant d\'accéder à cette page.';
                    break;
                case '1':
                    $message = 'Il y a eu une erreur lors de la connexion, veuillez réessayer';
                    break;
                default:
                    break;
            }
        }
        return $this->render('login.html.twig', [
            'message' => $message,
            'identified' => $identified,
        ]);
    }


    
    // La fonction qui déconnecte
    #[Route("/logout", name: "app_logout")]
    public function logout()
    {
        session_start();     // Pour une raison que j'ignore, ne pas mettre cette ligne alors que la session a déjà démarré retourne une fatal error 
        session_destroy();
        return $this->redirectToRoute('login');
    }
}
