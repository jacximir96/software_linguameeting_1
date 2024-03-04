<?php

namespace App\Src\Shared\Service;

trait FormSearchUniversityCourse
{
    protected function fillCourseOptions()
    {

        if (! $this->modelHasUniversitySelected()) {

            $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptions();

            return;
        }

        $universityIds = [];
        $model = $this->model();

        foreach ($model['university_id'] as $universityId) {
            if ($universityId) {
                $universityIds[] = $universityId;
            }
        }

        $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptionsFromUniversities($universityIds);

    }

    private function modelHasUniversitySelected(): bool
    {

        $model = $this->model();

        if (! isset($model['university_id'])) {
            return false;
        }

        if (is_array($model['university_id'])) {

            foreach ($model['university_id'] as $universityId) {
                if ($universityId) {
                    return true;
                }
            }
        }

        return false;
    }
}
