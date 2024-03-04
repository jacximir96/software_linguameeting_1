<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $universityOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function universityOptions(): array
    {
        return $this->universityOptions;
    }

    public function config()
    {
        $this->action = route('get.admin.register_code.bookstore_request.search');

        $this->configModelForm('bookstore_request_searcher');

        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityWithCodeOptions();
    }
}
