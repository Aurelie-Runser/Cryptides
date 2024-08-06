<?php

namespace App\Controller;

use App\Repository\ContinentRepository;
use App\Repository\CryptideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, CryptideRepository $cryptideRepository, ContinentRepository $continentRepository): Response
    {        
        $listeContinent = $continentRepository->findAll();
        
        $continentChoose = $request->query->get("continent");

        if(empty($continentChoose)) {
           $continentChoose = "europe";
        }

        $listeCryptide = $cryptideRepository->cryptidesByContinent($continentChoose);
        
        return $this->render('home/index.html.twig', [
            'continentChoose' => $continentChoose,
            'listeContinent' => $listeContinent,
            'listeCryptide' => $listeCryptide,
        ]);
    }

    #[Route('/a-propos', name: 'apropos')]
    public function contact(ContinentRepository $continentRepository): Response
    {
        // 2 variables nécessaires pour le menu
        $listeContinent = $continentRepository->findAll();
        $continentChoose = null;
       
        return $this->render('home/apropos.html.twig', [
            'continentChoose' => $continentChoose,
            'listeContinent' => $listeContinent
        ]);
    }
}
