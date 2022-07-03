<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/category")]
class CategoryController extends AbstractController
{
    #[Route("/", name: "category_index")]  
    public function categoryIndex() {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        if ($categories == null) {
            $this->addFlash("Error", "There is no category record yet");
        }
        return $this->render(
            "category/index.html.twig",
             [
                'categories' => $categories
             ]
        );
    }
 

    #[Route("/detail/{id}", name: "category_detail")]
    public function categoryDetail($id, ManagerRegistry $managerRegistry) {
       $category = $managerRegistry->getRepository(Category::class)->find($id);
       if ($category == null) {
          $this->addFlash("Error", "category not found");
          return $this->redirectToRoute("category_index");
       } 
       return $this->render("category/detail.html.twig",
       [
          'category' => $category
       ]);
    }
 
    #[Route("/delete/{id}", name: "category_delete")]
    public function categoryDelete ($id, CategoryRepository $categoryRepository) {
       $category = $categoryRepository->find($id);

       if ($category == null) {
          $this->addFlash("Error", "category not found !");
       }

       else if (count($category->getProducts()) >= 1) {
          $this->addFlash("Error", "Can not delete this category !");
       }

       else {
          $manager = $this->getDoctrine()->getManager();
          $manager->remove($category);
          $manager->flush();
          $this->addFlash("Success", "Delete category succeed !");
       }
       return $this->redirectToRoute("category_index");
    }
 

    #[Route("/add", name: "category_add")]
    public function addCategory(Request $request) {
       $category = new Category;
       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($request);
       $title = "Add new category";
       if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($category);
          $manager->flush();
          $this->addFlash("Success","Add category succeed !");
          return $this->redirectToRoute("category_index");
       }
       return $this->renderForm("category/save.html.twig",
       [
          'categoryForm' => $form,
          'title' => $title
       ]);
    }
 
    #[Route("/edit/{id}", name: "category_edit")]
    public function editCategory(Request $request, $id) {
       $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($request);
       $title = "Edit category";
       if ($form->isSubmitted() && $form->isValid()) {
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($category);
          $manager->flush();
          $this->addFlash("Success","Edit category succeed !");
          return $this->redirectToRoute("category_index");
       }
       return $this->renderForm("category/save.html.twig",
       [
          'categoryForm' => $form,
          'title' => $title
       ]);
    }
}
