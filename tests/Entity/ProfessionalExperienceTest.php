<?php

namespace App\Tests\Entity;

use App\Tests\EntityCreationTrait;
use PHPUnit\Framework\TestCase;

class ProfessionalExperienceTest extends TestCase
{
    use EntityCreationTrait;

    public function testFields()
    {
        $data = [
            'enterprise' => 'Mon Entreprise',
            'content' => 'Mon Super Contenu',
            'description' => 'Ma super description',
            'url' => 'https://example.test',
            'type' => 'Stage',
            'startDate' => 'Mai 2021',
            'endDate' => 'Mai 2022'
        ];
        $professionalExperience = $this->createProfessionalExperience(
            enterprise: $data['enterprise'],
            content: $data['content'],
            description: $data['description'],
            url: $data['url'],
            type: $data['type'],
            startDate: $data['startDate'],
            endDate: $data['endDate']
        );

        $this->assertEquals($data['enterprise'], $professionalExperience->getEnterprise());
        $this->assertEquals($data['content'], $professionalExperience->getContent());
        $this->assertEquals($data['description'], $professionalExperience->getDescription());
        $this->assertEquals($data['url'], $professionalExperience->getUrl());
        $this->assertEquals($data['type'], $professionalExperience->getType());
        $this->assertEquals($data['startDate'], $professionalExperience->getStartDate());
        $this->assertEquals($data['endDate'], $professionalExperience->getEndDate());
    }
}
