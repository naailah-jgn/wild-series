<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
            return $this->render('program/index.html.twig', [
                'programs' => $programs,
        ]);

        
    }
    
    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    // #[Route('/program/{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name: 'program_show')] //
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
            return $this->render('program/_show.html.twig', [
                'program' => $program,
        ]);

        
    }
}