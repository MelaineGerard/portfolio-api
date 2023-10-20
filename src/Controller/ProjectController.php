<?php

namespace App\Controller;

use App\Entity\Project;
use App\HttpCodeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/project', name: 'app_project_')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator
    ) {
    }


    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $projects = $this->entityManager->getRepository(Project::class)->findAll();

        return $this->json([
            'data' => $projects
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->json([
            'data' => $project
        ]);
    }

    /**
     * @throws \JsonException
     */
    #[Route('/', name: 'store', methods: ['POST'])]
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function store(?Project $project, Request $request): Response
    {
        $body = json_decode($request->getContent(), true, JSON_THROW_ON_ERROR);

        if (!$project instanceof Project) {
            $project = new Project();
        }

        $errors = $this->validator->validate($body, [
            'name' => new NotBlank(),
            'description' => new NotBlank(),
            'link' => new NotBlank(),
            'content' => new NotBlank(),
        ]);

        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException(json_encode($errors, JSON_THROW_ON_ERROR));
        }

        $project->setName($body['name']);
        $project->setDescription($body['description']);
        $project->setLink($body['link']);
        $project->setContent($body['content']);

        if (isset($body['featured']) && is_bool($body['featured'])) {
            $project->setFeatured($body['featured']);
        } else if ($project->isFeatured() === null) {
            $project->setFeatured(false);
        }

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this->json([
            'data' => $project
        ], HttpCodeEnum::CREATED->value);
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(Project $project): Response
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return $this->json([
            'data' => $project
        ]);
    }
}
