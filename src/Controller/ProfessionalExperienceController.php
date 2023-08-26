<?php

namespace App\Controller;

use App\Entity\ProfessionalExperience;
use App\Repository\ProfessionalExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

#[Route('/api/professional/experience', name: 'app_professional_experience_')]
class ProfessionalExperienceController extends AbstractController
{
    public function __construct(
        private readonly ProfessionalExperienceRepository $professionalExperienceRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $professionalExperiences = $this->professionalExperienceRepository->findAll();

        return $this->json([
            'data' => $professionalExperiences,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(ProfessionalExperience $professionalExperience): JsonResponse
    {
        return $this->json([
            'data' => $professionalExperience,
        ]);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function create(?ProfessionalExperience $professionalExperience, Request $request): JsonResponse
    {
        $validator = Validation::createValidator();
        if (!$professionalExperience instanceof ProfessionalExperience) {
            $professionalExperience = new ProfessionalExperience;
        }

        $data = (array) json_decode($request->getContent(), true);

        $violations = $validator->validate($data, new Collection([
            'type' => new NotBlank,
            'description' => new NotBlank,
            'start_date' => new NotBlank,
            'end_date' => new NotBlank,
            'enterprise' => new NotBlank,
            'url' => [
                new NotBlank,
                new Url,
            ],
            'content' => new NotBlank,
        ]));

        if (0 !== count($violations)) {
            return $this->json([
                'errors' => $violations,
            ], 422);
        }

        $professionalExperience->setType((string) $data['type']);
        $professionalExperience->setDescription((string) $data['description']);
        $professionalExperience->setStartDate((string) $data['start_date']);
        $professionalExperience->setEndDate((string) $data['end_date']);
        $professionalExperience->setEnterprise((string) $data['enterprise']);
        $professionalExperience->setUrl((string) $data['url']);
        $professionalExperience->setContent((string) $data['content']);

        $this->entityManager->persist($professionalExperience);
        $this->entityManager->flush();

        return $this->json([
            'data' => $professionalExperience,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(ProfessionalExperience $professionalExperience): JsonResponse
    {
        $this->entityManager->remove($professionalExperience);
        $this->entityManager->flush();

        return $this->json([
            'data' => $professionalExperience,
        ]);
    }
}
