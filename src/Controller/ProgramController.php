<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
            return $this->render('program/index.html.twig', [
                'programs' => $programs
        ]);
        
    }
    
    // #[Route('/show/{id<^[0-9]+$>}', name: 'show')] // 
   #[Route('/{id}', methods: ['GET'], requirements: ['{id}'=>'\d+'], name: 'show')] 
    public function show(Program $program, 
    SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findByProgram([$program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
           return $this->render('program/show.html.twig', [
                'program' => $program,
                'seasons' => $seasons,
        
        ]); 
    } 
    #[Route('/{programId}/season/{seasonId}',requirements: ['programId' => '\d+', 'seasonId' => '\d+'],
     methods: ['GET'], name: 'season_show')]
     public function showSeason(Program $programId, Season $seasonId, SeasonRepository $seasonRepository, 
     ProgramRepository $programRepository): Response
     {
        $program = $programRepository->findOneBy(['id' => $programId]);

         return $this->render(
             'program/season_show.html.twig',
             [
             'program' => $programId,
             'season' => $seasonId,
             ]
         );
     }


}