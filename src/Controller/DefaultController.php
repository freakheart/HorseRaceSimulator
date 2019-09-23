<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RaceService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Controller used to manage Races.
 */
class DefaultController extends AbstractController
{
    /**
     * @var RaceService
     */
    private $raceService;

    /**
     * RaceController constructor.
     * @param RaceService $raceService
     */
    public function __construct(RaceService $raceService) {
        $this->raceService = $raceService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index() {
        return $this->render('index.html.twig', [
            'activeRaces' => $this->raceService->getActiveRacesWithHorses(),
            'finishedRaces' => $this->raceService->getLastCompletedRacesWithHorses(),
            'bestEverHorse' => $this->raceService->getBestEverHorse()
        ]);
    }

    /**
     * @Route("/create", name="createRace")
     */
    public function createRace()
    {
        try {
            $this->raceService->createRace();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                "[Error]. " . $e->getMessage()
            );
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/progress", name="progressRaces")
     */
    public function progressRaces()
    {
        try {
            $this->raceService->progressRaces();
        } catch (\Exception $e) {
            $this->addFlash(
                'danger',
                "[Error]. " . $e->getMessage()
            );
        }

        return $this->redirectToRoute('index');
    }
}