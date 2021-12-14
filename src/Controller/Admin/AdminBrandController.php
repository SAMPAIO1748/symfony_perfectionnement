<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBrandController extends AbstractController
{
    public function listBrand(BrandRepository $brandRepository)
    {
        $brands = $brandRepository->findAll();

        return $this->render("admin/brands.html.twig", ['brands' => $brands]);
    }

    public function showBrand($id, BrandRepository $brandRepository)
    {
        $brand = $brandRepository->find($id);

        return $this->render('admin/brand.html.twig', ['brand' => $brand]);
    }

    public function updateBrand(
        $id,
        BrandRepository $brandRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {

        $brand = $brandRepository->find($id);

        $brandForm = $this->createForm(BrandType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_brand');
        }



        return $this->render("admin/brandform.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function createBrand(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $brand = new Brand();

        $brandForm = $this->createForm(brandType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $entityManagerInterface->persist($brand);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_brand');
        }

        return $this->render("admin/brandform.html.twig", ['brandForm' => $brandForm->createView()]);
    }

    public function deleteBrand(
        $id,
        EntityManagerInterface $entityManagerInterface,
        BrandRepository $brandRepository
    ) {
        $brand = $brandRepository->find($id);

        $entityManagerInterface->remove($brand);

        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_list_brand');
    }
}
