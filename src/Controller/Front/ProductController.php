<?php

namespace App\Controller\Front;

use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    // Créer les deux fonctions qui affichent la liste des produits avec leur name,
    // prix et le name de leur type et le name de leur brand et celle qui affiche
    // grâce à l'id un produit en particulier et tous les informations de ce produit
    // (name, price, stock, description, name du type, name de brand et toutes 
    // les images du produits.)


    public function listProduct(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render("front/products.html.twig", ['products' => $products]);
    }

    /**
     * @Route("front/product/{id}", name="front_show_product")
     */
    public function showProduct(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);

        return $this->render("front/product.html.twig", ['product' => $product]);
    }

    /**
     * @Route("/front/search/", name="front_search")
     */
    public function frontSearch(ProductRepository $productRepository, Request $request)
    {
        // Récupérer les données rentrées dans le formulaire
        $term = $request->query->get('term');

        $products = $productRepository->searchByTerm($term);

        return $this->render('front/search.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/front/like/product/{id}", name="product_like")
     */
    public function likeProduct(
        $id,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManagerInterface,
        LikeRepository $likeRepository
    ) {
        $product = $productRepository->find($id);
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => "Vous devez être connecté"
            ], 403);
        }

        if ($product->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy([
                'product' => $product,
                'user' => $user
            ]);

            $entityManagerInterface->remove($like);
            $entityManagerInterface->flush();

            return $this->json([
                'code' => 200,
                'message' => "Le like a été supprimé",
                'likes' => $likeRepository->count(['product' => $product])
            ], 200);
        }

        $like = new Like();
        $like->setProduct($product);
        $like->setUser($user);

        $entityManagerInterface->persist($like);
        $entityManagerInterface->flush();

        return $this->json([
            'code' => 200,
            'message' => "Le like a été enregistré",
            'likes' => $likeRepository->count(['product' => $product])
        ], 200);
    }
}
