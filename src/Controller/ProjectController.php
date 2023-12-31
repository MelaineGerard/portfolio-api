<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[Route('/api/project', name: 'app_project_')]
class ProjectController extends AbstractCrudController
{

    public function getEntity(): string
    {
        return Project::class;
    }

    public function getValidatorConstraints(): Collection
    {
        return new Collection([
            'name' => new NotBlank(),
            'description' => new NotBlank(),
            'link' => new Url(),
            'content' => new NotBlank(),
        ]);
    }
}
