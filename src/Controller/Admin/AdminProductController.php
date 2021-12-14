<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
