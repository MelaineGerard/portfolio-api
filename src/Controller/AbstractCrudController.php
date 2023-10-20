<?php

namespace App\Controller;

use App\HttpCodeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractCrudController extends AbstractController
{

    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly ValidatorInterface $validator
    ) {
    }

    public abstract function getEntity(): string;

    public abstract function getValidatorConstraints(): Collection;


    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $entities = $this->entityManager->getRepository($this->getEntity())->findAll();

        return $this->json([
            'data' => $entities
        ]);
    }



    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $entity = $this->entityManager->getRepository($this->getEntity())->find($id);

        if ($entity === null) {
            throw $this->createNotFoundException("Entity not found");
        }

        return $this->json([
            'data' => $entity
        ]);
    }

    /**
     * @throws \JsonException
     */
    #[Route('/', name: 'store', methods: ['POST'])]
    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function store(?int $id, Request $request): Response
    {
        $body = json_decode($request->getContent(), true, JSON_THROW_ON_ERROR);
        $entity = new ($this->getEntity())();

        if ($id !== null) {
            $entity = $this->entityManager->getRepository($this->getEntity())->find($id);

            if ($entity === null) {
                throw $this->createNotFoundException("Entity not found");
            }
        }

        $errors = $this->validator->validate($body, $this->getValidatorConstraints());

        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException(json_encode($errors, JSON_THROW_ON_ERROR));
        }

        foreach ($body as $key => $value) {
            $realKey = ucfirst(str_replace('_', '', ucwords($key, '_')));

            $method = 'set' . $realKey;
            $entity->$method($value);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $this->json([
            'data' => $entity
        ], HttpCodeEnum::CREATED->value);
    }

    #[Route('/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): Response
    {
        $entity = $this->entityManager->getRepository($this->getEntity())->find($id);

        if ($entity === null) {
            throw $this->createNotFoundException("Entity not found");
        }


        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return $this->json([
            'data' => $entity
        ]);
    }

}