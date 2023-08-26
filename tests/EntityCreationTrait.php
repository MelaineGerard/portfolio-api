<?php

namespace App\Tests;

use App\Entity\ProfessionalExperience;

trait EntityCreationTrait
{
    public function createProfessionalExperience(
        string $enterprise = 'Test',
        string $content = 'Test',
        string $description = 'Test',
        string $url = 'https://example.test',
        string $type = 'Stage',
        string $startDate = 'Mai 2021',
        string $endDate = 'Mai 2022',
    ): ProfessionalExperience {
        $professionalExperience = new ProfessionalExperience;

        $professionalExperience->setEnterprise($enterprise);
        $professionalExperience->setContent($content);
        $professionalExperience->setDescription($description);
        $professionalExperience->setUrl($url);
        $professionalExperience->setType($type);
        $professionalExperience->setStartDate($startDate);
        $professionalExperience->setEndDate($endDate);

        return $professionalExperience;
    }
}
