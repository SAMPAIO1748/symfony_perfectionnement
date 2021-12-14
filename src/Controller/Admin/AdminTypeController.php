<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{

    public function listType(TypeRepository $typeRepository)
    {
        $types = $typeRepository->findAll();

        return $this->render("admin/types.html.twig", ['types' => $types]);
    }

    public function showType($id, TypeRepository $typeRepository)
    {
        $type = $typeRepository->find($id);

        return $this->render('admin/type.html.twig', ['type' => $type]);
    }

    public function updateType(
        $id,
        TypeRepository $typeRepository,
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {

        $type = $typeRepository->find($id);

        $typeForm = $this->createForm(TypeType::class, $type);

        $typeForm->handleRequest($request);

        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            $entityManagerInterface->persist($type);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_type');
        }



        return $this->render("admin/typeform.html.twig", ['typeForm' => $typeForm->createView()]);
    }

    public function createType(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) {
        $type = new Type();

        $typeForm = $this->createForm(TypeType::class, $type);

        $typeForm->handleRequest($request);

        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            $entityManagerInterface->persist($type);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('admin_list_type');
        }

        return $this->render("admin/typeform.html.twig", ['typeForm' => $typeForm->createView()]);
    }

    public function deleteType(
        $id,
        EntityManagerInterface $entityManagerInterface,
        TypeRepository $typeRepository
    ) {
        $type = $typeRepository->find($id);

        $entityManagerInterface->remove($type);

        $entityManagerInterface->flush();

        return $this->redirectToRoute('admin_list_type');
    }
}
