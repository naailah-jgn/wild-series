<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    public ProgramRepository $programRepository;

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
            return $this->render('category/index.html.twig', [
                'categories' => $categories,
        ]);
    }

     #[Route('/{categoryName}', name: 'show')]
    // #[Route('/program/{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name: 'program_show')] //

    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category= $categoryRepository->findOneBy(['name'=>$categoryName]);
        

        if (!$category) {
            throw $this->createNotFoundException(
                'No category/program with name : '.$categoryName.' found in category\'s table.',
            );
        }

        $programs = $programRepository->findBy(['category' => $category->getId()],['id' => 'DESC'], 3);

            return $this->render('category/show.html.twig', ['programs' => $programs, 'category' => $category]);
    

    }
 }
