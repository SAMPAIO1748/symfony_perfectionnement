<?php

namespace App\Controller\Front;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{

    /**
     * @Route("front/types/", name="front_type_list")
     */
    public function typeList(TypeRepository $typeRepository)
    {
        $types = $typeRepository->findAll();

        return $this->render('front/types.html.twig', ['types' => $types]);
    }

    /**
     * @Route("front/type/{id}",  name="front_type_show")
     */
    public function typeShow($id, TypeRepository $typeRepository)
    {
        $type = $typeRepository->find($id);

        return $this->render('front/type.html.twig', ['type' => $type]);
    }
}
