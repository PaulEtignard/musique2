<?php

namespace App\Controller;

use App\Repository\NiveauRepository;
use App\Repository\SequenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NiveauController extends AbstractController
{

    private NiveauRepository $niveauRepository;
    private SequenceRepository $sequenceRepository;

    /**
     * @param NiveauRepository $niveauRepository
     */
    public function __construct(NiveauRepository $niveauRepository, SequenceRepository $sequenceRepository)
    {
        $this->niveauRepository = $niveauRepository;
        $this->sequenceRepository = $sequenceRepository;
    }


    #[Route('/niveau{slug}', name: 'app_niveau_slug')]
    public function getNiveauBySlug($slug): Response
    {

        $niveau = $this->niveauRepository->findBy(["slug"=>$slug]);
        $sequence = $this->sequenceRepository->findBy(["relation"=>$niveau]);
        return $this->render('niveau/index.html.twig', [
            'niveau' => 'NiveauController',
        ]);
    }
}
