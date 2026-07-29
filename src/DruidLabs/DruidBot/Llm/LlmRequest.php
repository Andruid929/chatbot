<?php

namespace DruidLabs\DruidBot\Llm;

use DruidLabs\DruidBot\Models\Model;
use DruidLabs\DruidBot\Utils\Attachment;

/**
 * Class LlmRequest
 *
 * Represents a request to be sent to an LLM.
 */
class LlmRequest {
    /**
     * @var string The ID of the model to use.
     */
    private string $model;

    /**
     * @var string The prompt text.
     */
    private string $prompt;

    /**
     * @var Attachment[] The attachments associated with the request.
     */
    private array $attachments;

    /**
     * LlmRequest constructor.
     *
     * @param Model $model The model to use.
     * @param string $prompt The prompt text.
     * @param Attachment[] $attachments The attachments associated with the request.
     */
    public function __construct(Model $model, string $prompt, array $attachments = []) {
        $this->model = $model->asString();
        $this->prompt = $prompt;
        $this->attachments = $attachments;
    }

    /**
     * Returns the model ID.
     *
     * @return string The model ID.
     */
    public function modelId(): string {
        return $this->model;
    }

    /**
     * Returns the prompt text.
     *
     * @return string The prompt text.
     */
    public function prompt(): string {
        return $this->prompt;
    }

    /**
     * Returns the attachments.
     *
     * @return Attachment[] The attachments.
     */
    public function attachments(): array {
        return $this->attachments;
    }

    /**
     * Adds an attachment to the request.
     *
     * @param Attachment $attachment The attachment to add.
     */
    public function addAttachment(Attachment $attachment): void
    {
        $this->attachments[] = $attachment;
    }
}
