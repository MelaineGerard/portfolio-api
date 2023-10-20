<?php

namespace App\Controller;

use App\Entity\ProfessionalExperience;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[Route('/api/professional-experience', name: 'app_professional_experience_')]
class ProfessionalExperienceController extends AbstractCrudController
{

    public function getEntity(): string
    {
        return ProfessionalExperience::class;
    }

    public function getValidatorConstraints(): Collection
    {
        return new Collection([
            'enterprise' => new NotBlank(),
            'type' => new NotBlank(),
            'description' => new NotBlank(),
            'content' => new NotBlank(),
            'url' => new Url(),
            'start_date' => new NotBlank(),
            'end_date' => new NotBlank(),
        ]);
    }
}
