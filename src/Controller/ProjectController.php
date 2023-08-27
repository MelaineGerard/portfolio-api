<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[Route('/api/project', name: 'app_api_project_')]
class ProjectController extends AbstractApiController
{
    public function getEntityClass(): string
    {
        return Project::class;
    }

    public function getValidatorRules(): array
    {
        return [
            'name' => [
                new NotBlank,
            ],
            'description' => [
                new NotBlank,
            ],
            'content' => [
                new NotBlank,
            ],
            'url' => [
                new NotBlank,
                new Url,
            ],
        ];
    }
}
