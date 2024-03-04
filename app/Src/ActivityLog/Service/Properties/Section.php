<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\CourseDomain\Section\Model\Section as SectionModel;

class Section implements Property
{
    private SectionModel $section;

    public function __construct(SectionModel $section){

        $this->section = $section;
    }

    public function buildProperty(string $key, string $title = ''): array
    {
        return [
            $key => [
                'title' => $title,
                'type' => 'section',
                'id' => $this->section->id,
            ]
        ];
    }
}
