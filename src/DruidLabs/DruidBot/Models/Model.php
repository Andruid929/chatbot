<?php

namespace DruidLabs\DruidBot\Models;

/**
 * Interface Model
 *
 * Defines the contract for an LLM model.
 */
interface Model {

    /**
     * Returns the model ID as a string.
     *
     * @return string The model ID.
     */
    public function asString(): string;
}
