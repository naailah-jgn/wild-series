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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/Program', name: 'Program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        if (!$session->has('total')) {
            $session->set('total', 0); // if total doesn’t exist in session, it is initialized.
        }
        $total = $session->get('total'); // get actual value in session with ‘total' key.//
        $programs = $programRepository->findAll();
            return $this->render('program/index.html.twig', [
                'Programs' => $programs
        ]);
        
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);     
            
            // Once the form is submitted, valid and the data inserted in database, you can define the success flash message
            $this->addFlash('success', 'The new program has been created');
            return $this->redirectToRoute('Program_index');
        }
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]); 
    }
    
    // #[Route('/show/{id<^[0-9]+$>}', name: 'show')] // 
   #[Route('/{id}', methods: ['GET'], requirements: ['{id}'=>'\d+'], name: 'show')] 
    public function show(Program $program /*, Season $seasons */): Response
    {
        // $seasons = $seasonRepository->findByProgram([$Program]); //

        if (!$program) {
            throw $this->createNotFoundException(
                'No Program found in Program\'s table.'
            );
        }
             return $this->render('program/show.html.twig', [
                'Program' => $program, 
              //  'seasons' => $seasons, //
        
        ]);
    } 
    #[Route('/{ProgramId}/seasons/{seasonId}',requirements: ['Program' => '\d+', 'season' => '\d+'],
     methods: ['GET'], name: 'season_show')]
     #[Entity('Program', options: ['mapping' => ['ProgramId' => 'id']])]
     #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
     public function showSeason(Program $program, Season $season)
     {
       // $Program = $ProgramRepository->findOneBy(['id' => $ProgramId]);//
         return $this->render(
             'program/season_show.html.twig',
             [
             'Program' => $program,
             'season' => $season,
             ]
         ); 
     }
     #[Route('/{ProgramId}/seasons/{seasonId}/episode/{episodeId}', methods: ['GET'], name: 'episode_show')]
     #[Entity('Program', options: ['mapping' => ['ProgramId' => 'id']])]
     #[Entity('season', options: ['mapping' => ['seasonId' => 'id']])]
     #[Entity('episode', options: ['mapping' => ['episodeId' => 'id']])]
     public function showEpisode(Program $program, Season $season, Episode $episode)
     {

        return $this->render(
            'program/episode_show.html.twig',
            [
            'Program' => $program,
            'season' => $season,
            'episode' => $episode,
            ]
        );
     }
     


}