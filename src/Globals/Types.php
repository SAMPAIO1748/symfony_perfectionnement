<?php

namespace App\Globals;

use App\Repository\TypeRepository;

class Types
{
    private $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function getAll()
    {
        $gtypes = $this->typeRepository->findAll();

        return $gtypes;
    }
}
