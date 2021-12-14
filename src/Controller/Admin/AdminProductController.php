<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductController extends AbstractController
{

    /**
     * @Route("/admin/products", name="admin_product_list")
     */
    public function listProduct(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render("admin/products.html.twig", ['products' => $products]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin_product_show")
     */
    public function showProduct(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);

        return $this->render("admin/product.html.twig", ['product' => $product]);
    }

    /**
     * @Route("/admin/update/product/{id}", name="admin_update_product")
     */
    public function productUpdate(
        $id,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $product = $productRepository->find($id);

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }


        return $this->render('admin/productform.html.twig', ['productForm' => $productForm->createView()]);
    }

    /**
     * @Route("/admin/create/product/", name="admin_create_product")
     */
    public function productCreate(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $product = new Product();

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }


        return $this->render('admin/productform.html.twig', ['productForm' => $productForm->createView()]);
    }

    /**
     * @Route("/admin/delete/product/{id}", name="admin_delete product")
     */
    public function deleteProduct(
        $id,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManagerInterface
    ) {
        $product = $productRepository->find($id);

        $entityManagerInterface->remove($product);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_product_list");
    }
}
