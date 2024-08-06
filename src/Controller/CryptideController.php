<?php

namespace App\Controller;

use App\Repository\ContinentRepository;
use App\Repository\CryptideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CryptideController extends AbstractController
{
    #[Route('/cryptide', name: 'cryptide.index')]
    public function index(): Response
    {        
        return $this->redirectToRoute('home');
    }
    
    #[Route('/cryptide/hasard', name: 'cryptide.hasard')]
    public function hasard(CryptideRepository $cryptideRepository): Response
    {
        $listeCryptide = $cryptideRepository->findAll(); // récupère tous les cryptides

        $cryptide = $listeCryptide[random_int(0, count($listeCryptide) - 1)]; // prend un cryptide aléatoir
    
        return $this->redirectToRoute('cryptide.show', [
            'slug' => $cryptide->getSlug(),
        ]);
    }
    
    
    #[Route('/cryptide/{slug}', name: 'cryptide.show', requirements: ['slug' => '[A-Za-z0-9-]+'])]
    public function show(string $slug, CryptideRepository $cryptideRepository, ContinentRepository $continentRepository): Response
    {
        $listeContinent = $continentRepository->findAll(); // récupère tous les continents pour le menu
                            
        if ($slug == 'hasard'){ // si le slug ne correspon a aucun cryptide
            
            $listeCryptide = $cryptideRepository->findAll(); // récupère tous les cryptides
            $randomCryptide = rand(0, count($listeCryptide) - 1);
            
            $cryptide = $listeCryptide[$randomCryptide]; // prend un cryptide aléatoire

            return $this->redirectToRoute('cryptide.show', [
                'slug' => $cryptide->getSlug(),
            ]);
        }

        $cryptide = $cryptideRepository->findOneBy(['slug' => $slug]); // récupère le cryptide choisi à partir du slug
        
        $continentChoose = $cryptide->getIdContinent()->getSlug(); // renvoie le slug, pour que l'icon du continent du cryptide soit différent
        
        return $this->render('cryptide/show.html.twig', [
            'cryptide' => $cryptide,
            'continentChoose' => $continentChoose,
            'listeContinent' => $listeContinent
        ]);
    }
}
