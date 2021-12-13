<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    // Créer les deux fonctions qui affichent la liste des produits avec leur name,
    // prix et le name de leur type et le name de leur brand et celle qui affiche
    // grâce à l'id un produit en particulier et tous les informations de ce produit
    // (name, price, stock, description, name du type, name de brand et toutes 
    // les images du produits.)


    /**
     * @Route("/front/products/", name="front_list_product")
     */
    public function listProduct(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render("front/products.html.twig", ['products' => $products]);
    }
}
