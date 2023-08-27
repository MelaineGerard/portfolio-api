<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return class-string<object>
     */
    abstract public function getEntityClass(): string;

    /**
     * @return array<string, array<Constraint>>
     */
    abstract public function getValidatorRules(): array;

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $entities = $this->entityManager->getRepository($this->getEntityClass())->findAll();

        return $this->json([
            'data' => $entities,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $entity = $this->entityManager->getRepository($this->getEntityClass())->find($id);

        if (!$entity instanceof ($this->getEntityClass())) {
            return $this->json([
                'error' => 'Not found',
            ], 404);
        }

        return $this->json([
            'data' => $entity,
        ]);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function create(?int $id, Request $request): JsonResponse
    {
        $validator = Validation::createValidator();
        $entity = new ($this->getEntityClass());

        if (null !== $id) {
            $entityDb = $this->entityManager->getRepository($this->getEntityClass())->find($id);

            if (!$entityDb instanceof ($this->getEntityClass())) {
                return $this->json([
                    'error' => 'Not found',
                ], 404);
            }
        }

        $data = (array) json_decode($request->getContent(), true);

        $violations = $validator->validate($data, new Collection($this->getValidatorRules()));

        if (0 !== count($violations)) {
            return $this->json([
                'errors' => $violations,
            ], 422);
        }

        foreach ($data as $key => $value) {
            $setter = 'set' . ucwords($key);

            // Faire en sorte que phpstan ne donne pas l'erreur " Variable method call on object."
            if (method_exists($entity, $setter)) {
                $entity->$setter($value); // @phpstan-ignore-line
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $this->json([
            'data' => $entity,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(int $id): JsonResponse
    {
        $entity = $this->entityManager->getRepository($this->getEntityClass())->find($id);

        if (!$entity instanceof ($this->getEntityClass())) {
            return $this->json([
                'error' => 'Not found',
            ], 404);
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return $this->json([
            'data' => $entity,
        ]);
    }
}
