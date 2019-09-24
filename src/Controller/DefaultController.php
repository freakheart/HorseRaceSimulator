<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RaceService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller used to manage Races.
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param RaceService $raceService
     *
     * @return Response
     */
    public function index(RaceService $raceService)
    {
        return $this->render('index.html.twig', [
            'activeRaces' => $raceService->getActiveRacesWithHorses(),
            'finishedRaces' => $raceService->getLastCompletedRacesWithHorses(),
            'bestEverHorse' => $raceService->getBestEverHorse(),
        ]);
    }

    /**
     * @Route("/create", name="createRace")
     *
     * @param RaceService $raceService
     *
     * @return RedirectResponse
     */
    public function createRace(RaceService $raceService)
    {
        try {
            $raceService->createRace();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                '[Error]. '.$e->getMessage()
            );
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/progress", name="progressRaces")
     *
     * @param RaceService $raceService
     *
     * @return RedirectResponse
     */
    public function progressRaces(RaceService $raceService)
    {
        try {
            $raceService->progressRaces();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                '[Error]. '.$e->getMessage()
            );
        }

        return $this->redirectToRoute('index');
    }
}
