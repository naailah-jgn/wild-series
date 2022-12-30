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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\ProgramType;

#[Route('/Program', name: 'Program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $ProgramRepository): Response
    {
        $Programs = $ProgramRepository->findAll();
            return $this->render('Program/index.html.twig', [
                'Programs' => $Programs
        ]);
        
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $ProgramRepository): Response
    {
        $Program = new Program();
        $form = $this->createForm(ProgramType::class, $Program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ProgramRepository->save($Program, true);     
                 
            return $this->redirectToRoute('Program_index');
        }
        return $this->renderForm('Program/new.html.twig', [
            'form' => $form,
        ]);
    }
    
    // #[Route('/show/{id<^[0-9]+$>}', name: 'show')] // 
   #[Route('/{id}', methods: ['GET'], requirements: ['{id}'=>'\d+'], name: 'show')] 
    public function show(Program $Program /*, Season $seasons */): Response
    {
        // $seasons = $seasonRepository->findByProgram([$Program]); //

        if (!$Program) {
            throw $this->createNotFoundException(
                'No Program found in Program\'s table.'
            );
        }
           return $this->render('Program/show.html.twig', [
                'Program' => $Program,
               /* 'seasons' => $seasons, */
        
        ]); 
    } 
    #[Route('/{ProgramId}/seasons/{seasonId}',requirements: ['Program' => '\d+', 'season' => '\d+'],
     methods: ['GET'], name: 'season_show')]
     #[Entity('Program', options: ['mapping' => ['ProgramId' => 'id']])]
     #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
     public function showSeason(Program $Program, Season $season): Response
     {
       // $Program = $ProgramRepository->findOneBy(['id' => $ProgramId]);//
         return $this->render(
             'Program/season_show.html.twig',
             [
             'Program' => $Program,
             'season' => $season,
             ]
         );
     }
     #[Route('/{ProgramId}/seasons/{seasonId}/episode/{episodeId}', methods: ['GET'], name: 'episode_show')]
     #[Entity('Program', options: ['mapping' => ['ProgramId' => 'id']])]
     #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
     #[Entity('episode', options: ['mapping' => ['episodeId' => 'id']])]
     public function showEpisode(Program $Program, Season $season, Episode $episode)
     {

        return $this->render(
            'Program/episode_show.html.twig',
            [
            'Program' => $Program,
            'season' => $season,
            'episode' => $episode,
            ]
        );
     }


}