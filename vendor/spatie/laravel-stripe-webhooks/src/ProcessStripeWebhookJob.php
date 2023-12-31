<?php

namespace Spatie\StripeWebhooks;

use Spatie\StripeWebhooks\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessStripeWebhookJob extends ProcessWebhookJob
{
    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
        $this->onConnection(config('stripe-webhooks.connection'));
        $this->onQueue(config('stripe-webhooks.queue'));
    }

    public function handle()
    {
        if (! isset($this->webhookCall->payload['type']) || $this->webhookCall->payload['type'] === '') {
            throw WebhookFailed::missingType($this->webhookCall);
        }

        event("stripe-webhooks::{$this->webhookCall->payload['type']}", $this->webhookCall);

        $jobClass = $this->determineJobClass($this->webhookCall->payload['type']);

        if ($jobClass === '') {
            return;
        }

        if (! class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $this->webhookCall);
        }

        dispatch(new $jobClass($this->webhookCall));
    }

    protected function determineJobClass(string $eventType): string
    {
        $jobConfigKey = str_replace('.', '_', $eventType);

        $defaultJob = config('stripe-webhooks.default_job', '');

        return config("stripe-webhooks.jobs.{$jobConfigKey}", $defaultJob);
    }
}
