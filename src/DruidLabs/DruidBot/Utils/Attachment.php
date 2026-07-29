<?php

namespace DruidLabs\DruidBot\Utils;

/**
 * Class Attachment
 *
 * Represents a file attachment that can be sent to an LLM.
 */
class Attachment {

    /**
     * @var string The major type of the file (e.g., 'image', 'document').
     */
    private string $type;

    /**
     * @var string The full MIME type of the file.
     */
    private string $mimeType;

    /**
     * @var string The raw binary data of the file.
     */
    private string $data; // raw bytes

    /**
     * Attachment constructor.
     *
     * @param string $mimeType The full MIME type of the file.
     * @param string $data The raw binary data of the file.
     * @param string $type The major type of the file.
     */
    public function __construct(string $mimeType, string $data, string $type) {
        $this->mimeType = $mimeType;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Returns the raw binary data.
     *
     * @return string The raw binary data.
     */
    public function getData(): string {
        return $this->data;
    }

    /**
     * Returns the MIME type.
     *
     * @return string The MIME type.
     */
    public function getMimeType(): string {
        return $this->mimeType;
    }

    /**
     * Returns the major type.
     *
     * @return string The major type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns the base64 encoded data.
     *
     * @return string The base64 encoded data.
     */
    public function getBase64Data(): string {
        return base64_encode($this->data);
    }
}
