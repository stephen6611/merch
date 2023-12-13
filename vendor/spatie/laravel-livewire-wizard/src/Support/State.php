<?php

namespace Spatie\LivewireWizard\Support;

use Illuminate\Support\Arr;

class State
{
    protected array $allState = [];
    protected string $currentStepName = '';

    public function setAllState(array $state): self
    {
        $this->allState = $state;

        return $this;
    }

    public function setCurrentStepName(string $currentStepName): self
    {
        $this->currentStepName = $currentStepName;

        return $this;
    }

    public function forStep(string $stepName): array
    {
        $state = $this->allState[$stepName] ?? [];

        if (array_key_exists('allStepsState', $state)) {
            unset($state['allStepsState']);
        }

        return $state;
    }

    public function get(string $key)
    {
        return Arr::get($this->allState, $key);
    }

    public function currentStep(): array
    {
        return $this->forStep($this->currentStepName);
    }

    public function all(): array
    {
        return $this->allState;
    }
}
