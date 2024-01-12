<?php

namespace App\MessageHandler;

use App\Message\FetchApodMessage;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

// Ici c'est la fonction qui est executée automatiquement chaque jour pour mettre à jour la BDD

#[AsMessageHandler]
final class FetchApodHandler
{

    // J'ai eu besoin de doctrine pour mes problèmes de BDD
    public function __construct(private ManagerRegistry $doctrine)
    {

    }

    public function __invoke(FetchApodMessage $message)
    {
        // On va chercher l' entityManager alternatif pour que la connexion à la BDD puisse se faire correctement
        $entityManager = $this->doctrine->getManager('alternate');
        $apodRepository = $entityManager->getRepository(Picture::class);

        // On traduit l'ensemble d'info récupérées via l'API de la NASA en un tableau
        $apod = json_decode(file_get_contents('https://api.nasa.gov/planetary/apod?api_key=N5TlbLpP3s1tBs1ZNJo6o3RfJEVE7ilntkyEbslZ'));

        $date = $apod->date;
        // On vérifie que la photo de ce jour n'existe pas déjà dans la BDD
        if (!$apodRepository->findOneBy(["date" => $date])) {
            // On ne veut que des images
            if ($apod->media_type == "image") {

                // Ici on télécharge la photo d'abord en SD puis en HD
                $url = $apod->url;
                $path = 'public/assets/img/apod/sd/apod_' . $date . ".png";
                file_put_contents($path, file_get_contents($url));
                $hdurl = $apod->hdurl;
                $hdpath = 'public/assets/img/apod/hd/hd_apod_' . $date . ".png";
                file_put_contents($hdpath, file_get_contents($hdurl));

                // Insertion classique en BDD
                $picture = new Picture;
                $picture->setTitle(isset($apod->title) ? trim($apod->title) : "none");
                $picture->setCopyright(isset($apod->copyright) ? trim($apod->copyright) : "Nasa");
                $picture->setDate($date);
                $picture->setExplanation(isset($apod->explanation) ? trim($apod->explanation) : "none");
                $picture->setMediaType(isset($apod->media_type) ? trim($apod->media_type) : "none");
                $picture->setHdurl($hdurl);
                $picture->setUrl($url);
                $picture->setHdpath($hdpath);
                $picture->setPath($path);

                $entityManager->persist($picture);
            }
            $entityManager->flush();
        }
    }
}
