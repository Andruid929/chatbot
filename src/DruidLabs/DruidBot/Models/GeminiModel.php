<?php

namespace DruidLabs\DruidBot\Models;

/**
 * Enum GeminiModel
 *
 * Represents the available Google Gemini models.
 */
enum GeminiModel: string implements Model {
    /**
     * Gemini 3.5 Flash model.
     */
    case GEMINI_3_5_FLASH = 'gemini-3.5-flash';

    /**
     * Gemini 3.6 Flash model.
     */
    case GEMINI_3_6_FLASH = 'gemini-3.6-flash';

    /**
     * Returns a description of the model.
     *
     * @return string The model description.
     */
    public function description(): string {
        return match($this) {
            self::GEMINI_3_5_FLASH => 'Used to be most intelligent model for sustained frontier performance in agentic and coding tasks.',
            self::GEMINI_3_6_FLASH => 'Most intelligent model for sustained frontier performance in agentic and coding tasks.',
        };
    }

    /**
     * Returns the model ID as a string.
     *
     * @return string The model ID.
     */
    public function asString(): string {
        return $this->value;
    }

    /**
     * Returns a GeminiModel instance from a model ID string.
     *
     * @param string $modelId The model ID string.
     * @return self|null The GeminiModel instance, or null if not found.
     */
    public static function getModel(string $modelId): ?self {
        return self::tryFrom($modelId);
    }
}
