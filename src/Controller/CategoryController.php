<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Season;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    public ProgramRepository $ProgramRepository;

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new (Request $request, CategoryRepository $categoryRepository): Response
    {
        // Create a new Category Object //
        $category = new Category();
        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $categoryRepository->save($category, true); 
            return $this->redirectToRoute('category_index');
        }
            // Render the form (best practice)
            return $this->renderForm('category/new.html.twig', [
                'form' => $form,
            ]);

            // Alternative
            // return $this->render('category/new.html.twig', [
            //   'form' => $form->createView(),
            // ]);
        
    }

    #[Route('/{categoryName}', name: 'show')]
    // #[Route('/Program/{id}', methods: ['GET'], requirements: ['page'=>'\d+'], name: 'Program_show')] //

    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $ProgramRepository): Response
    {
        $category= $categoryRepository->findOneBy(['name'=>$categoryName]);
        

        if (!$category) {
            throw $this->createNotFoundException(
                'No category/Program with name : '.$categoryName.' found in category\'s table.',
            );
        }

        $Programs = $ProgramRepository->findBy(['category' => $category->getId()],['id' => 'DESC'], 3);

            return $this->render('category/show.html.twig', ['Programs' => $Programs, 'category' => $category]);
    }
   
    
 }
