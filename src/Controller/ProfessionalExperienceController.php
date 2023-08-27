<?php

namespace App\Controller;

use App\Entity\ProfessionalExperience;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[Route('/api/professional/experience', name: 'app_api_professional_experience_')]
class ProfessionalExperienceController extends AbstractApiController
{
    public function getEntityClass(): string
    {
        return ProfessionalExperience::class;
    }

    public function getValidatorRules(): array
    {
        return [
            'type' => [
                new NotBlank,
            ],
            'description' => [
                new NotBlank,
            ],
            'start_date' => [
                new NotBlank,
            ],
            'end_date' => [
                new NotBlank,
            ],
            'enterprise' => [
                new NotBlank,
            ],
            'url' => [
                new NotBlank,
                new Url,
            ],
            'content' => [
                new NotBlank,
            ],
        ];
    }
}
