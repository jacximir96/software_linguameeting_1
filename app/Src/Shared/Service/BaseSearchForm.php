<?php

declare(strict_types=1);

namespace App\Src\Shared\Service;

use Carbon\Carbon;

abstract class BaseSearchForm
{
    protected $action = '';

    protected $model = [];

    protected $isEdit = false;

    public function action(): string
    {
        return $this->action;
    }

    public function model(): array
    {
        return $this->model;
    }

    public function modelHasField(string $field): bool
    {
        return isset($this->model[$field]);
    }

    public function isCreate(): bool
    {
        return ! $this->isEdit();
    }

    public function isEdit(): bool
    {
        return $this->isEdit;
    }

    protected function configDate(string $dateField, Carbon $date)
    {
        $this->model[$dateField] = $date->toDateString();
    }

    public function configModelForm(string $formKey, array $customConfiguration = [])
    {
        if ($this->hasFormBeenSubmitted()) {
            $this->configModelFormFromSubmit($formKey, $customConfiguration);

            $this->saveModelInSession($formKey);
        } elseif ($this->hasRequestFromUrl()) {
            $this->configModelFromUrl($formKey);
        } else {
            $this->configModelFormFromSession($formKey, $customConfiguration);
        }
    }

    private function hasFormBeenSubmitted(): bool
    {
        return request()->isMethod('POST');
    }

    private function hasRequestFromUrl(): bool
    {
        return request()->has('from_url');
    }

    private function configModelFormFromSubmit(string $formKey, array $customConfiguration = [])
    {
        $formFields = config('linguameeting.list.search_form_config.'.$formKey.'.fields');
        $model = request()->only($formFields);
        $model['page'] = 1;
        $model = array_merge($model, $customConfiguration);

        $this->model = $model;
    }

    private function configModelFromUrl(string $formKey)
    {
        $formFields = config('linguameeting.list.search_form_config.'.$formKey.'.fields');
        $model = request()->only($formFields);
        $model['page'] = 1;

        $this->model = $model;
    }

    private function saveModelInSession(string $formKey)
    {
        $key = $this->buildKeyForm($formKey);
        session([$key => $this->model]);
    }

    private function configModelFormFromSession(string $formKey, array $customConfiguration = [])
    {
        $finalKeyInSession = $this->buildKeyForm($formKey);

        if (session()->exists($finalKeyInSession)) {
            $this->model = session()->get($finalKeyInSession);
        }

        $this->model = array_merge($this->model, $customConfiguration);

        $this->model['page'] = $this->obtainPage($formKey);

        session([$finalKeyInSession => $this->model]);
    }

    private function obtainPage(string $formKey): int
    {
        if (request()->has('page')) {
            return (int) request()->get('page');
        }

        $finalKeyInSession = $this->buildKeyForm($formKey);

        if ($this->isPageInSession($finalKeyInSession)) {
            return session()->get($this->pageKey($finalKeyInSession));
        }

        return 1;
    }

    private function isPageInSession(string $formKey): bool
    {
        return session()->exists($this->pageKey($formKey));
    }

    private function pageKey(string $formKey): string
    {
        return $this->buildKeyForm($formKey).'.page';
    }

    protected function buildKeyForm(string $formKey): string
    {
        return 'search-form.'.$formKey;
    }
}
