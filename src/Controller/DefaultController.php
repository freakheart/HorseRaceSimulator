<?php

namespace App\Controller;

use App\Service\RaceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(RaceService $raceService): Response
    {
        return $this->render('index.html.twig', [
            'activeRaces' => $raceService->getActiveRacesWithHorses(),
            'finishedRaces' => $raceService->getLastCompletedRacesWithHorses(),
            'bestEverHorse' => $raceService->getBestEverHorse(),
        ]);
    }

    #[Route('/create', name: 'createRace')]
    public function createRace(RaceService $raceService): RedirectResponse
    {
        try {
            $raceService->createRace();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                '[Error]. '.$e->getMessage()
            );
        }

        return $this->redirectToRoute('default');
    }

    #[Route('/progress', name: 'progressRaces')]
    public function progressRaces(RaceService $raceService): RedirectResponse
    {
        try {
            $raceService->progressRaces();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                '[Error]. '.$e->getMessage()
            );
        }

        return $this->redirectToRoute('default');
    }
}
