<?php

namespace DruidLabs\DruidBot\Utils;

/**
 * Class FileReader
 *
 * Provides utility methods for reading files and creating Attachment instances.
 */
class FileReader
{
    /**
     * Reads a file from the given path and returns an Attachment instance.
     *
     * @param string $filePath The path to the file to read.
     * @return Attachment The created Attachment instance.
     * @throws \Exception If the file is not found or cannot be read.
     */
    public static function readFile(string $filePath): Attachment
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new \Exception("Failed to read file: $filePath");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        $type = explode('/', $mimeType)[0]; // Get the type (e.g., 'image', 'text', etc.)

        return new Attachment(mimeType: $mimeType, data: $content, type: $type);
    }
}
