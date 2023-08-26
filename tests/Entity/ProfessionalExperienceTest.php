<?php

namespace App\Tests\Entity;

use App\Tests\EntityCreationTrait;
use PHPUnit\Framework\TestCase;

class ProfessionalExperienceTest extends TestCase
{
    use EntityCreationTrait;

    /**
     * @test
     */
    public function fields(): void
    {
        $data = [
            'enterprise' => 'Mon Entreprise',
            'content' => 'Mon Super Contenu',
            'description' => 'Ma super description',
            'url' => 'https://example.test',
            'type' => 'Stage',
            'startDate' => 'Mai 2021',
            'endDate' => 'Mai 2022',
        ];
        $professionalExperience = self::createProfessionalExperience(
            enterprise: $data['enterprise'],
            content: $data['content'],
            description: $data['description'],
            url: $data['url'],
            type: $data['type'],
            startDate: $data['startDate'],
            endDate: $data['endDate']
        );

        self::assertEquals($data['enterprise'], $professionalExperience->getEnterprise());
        self::assertEquals($data['content'], $professionalExperience->getContent());
        self::assertEquals($data['description'], $professionalExperience->getDescription());
        self::assertEquals($data['url'], $professionalExperience->getUrl());
        self::assertEquals($data['type'], $professionalExperience->getType());
        self::assertEquals($data['startDate'], $professionalExperience->getStartDate());
        self::assertEquals($data['endDate'], $professionalExperience->getEndDate());
    }
}
