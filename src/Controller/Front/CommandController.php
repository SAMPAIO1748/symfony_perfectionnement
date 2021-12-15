<?php

namespace App\Controller\Front;

use App\Repository\CommandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandController extends AbstractController
{

    public function listCommand(CommandRepository $commandRepository)
    {
        $commands = $commandRepository->findAll();

        return $this->render("front/commands.html.twig", ['commands' => $commands]);
    }

    public function showCommand($id, CommandRepository $commandRepository)
    {
        $command = $commandRepository->find($id);

        return $this->render("front/command.html.twig", ["command" => $command]);
    }
}
