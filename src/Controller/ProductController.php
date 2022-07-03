<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;


#[Route("/product")]
class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function productIndex(ProductRepository $productRepository) {
        $products = $productRepository->findAll();
        return $this->render("product/index.html.twig",
        [
            'products' => $products
        ]);
    } 

    #[Route('/detail/{id}', name: 'product_detail')]
    public function productDetail(ManagerRegistry $managerRegistry, $id) {
        $product = $managerRegistry->getRepository(Product::class)->find(($id));
        if ($product == null) {
            //gửi flash message về view
            $this->addFlash("Error","product not found !");
            return $this->redirectToRoute("product_index");
        } else {
            return $this->render("product/detail.html.twig",
            [
                'product' => $product
            ]);
        }
    }

    #[Route("/delete/{id}", name: 'product_delete')]
    public function productDelete(ProductRepository $productRepository, $id) {
        $product = $productRepository->find($id);
        if ($product == null) {
            $this->addFlash("Error", "Can not delete this product !");
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();
            $this->addFlash("Success", "Delete product succeed !");
        }
        return $this->redirectToRoute("product_index");
    }

    #[Route("/add", name: 'product_add' )]
    public function productAdd(Request $request, ManagerRegistry $managerRegistry) {
        $product = new Product;
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash("Success", "Add new product successfully !");
            return $this->redirectToRoute("product_index");
        }
        return $this->renderForm("product/add.html.twig",
        [
            'productForm' => $form
        ]);
    }


    #[Route("/edit/{id}", name: 'product_edit')]
    public function productEdit(Request $request, $id) {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        if ($product == null) {
            $this->addFlash("Error","Can not update non-existed product !");   
            return $this->redirectToRoute("product_index");
        } else {
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();
                $this->addFlash("Success", "Update product successfully !");
                return $this->redirectToRoute("product_index");
            }
        }
        return $this->renderForm("product/edit.html.twig",
        [
            'productForm' => $form
        ]);
    }
}
