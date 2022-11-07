<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObject;

/**
 * class EmbeddedFile.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class EmbeddedFile
{
    private ?string $name = null;

    private ?string $originalName = null;

    private ?string $mimeType = null;

    private ?int $size = null;

    private ?array $dimensions = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(?array $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    /**
     * A simple shortcut to the image width.
     * Similar to `$file->getDimensions()[0]`.
     *
     * @return int|null Returns `null` if dimensions array is itself null
     */
    public function getWidth(): ?int
    {
        return $this->dimensions ? (int) $this->dimensions[0] : null;
    }

    /**
     * A simple shortcut to the image height.
     * Similar to `$file->getDimensions()[1]`.
     *
     * @return int|null Returns `null` if dimensions array is itself null
     */
    public function getHeight(): ?int
    {
        return $this->dimensions ? (int) $this->dimensions[1] : null;
    }

    /**
     * Format image dimensions for use with html (to avoid layout shifting).
     *
     * Usage in twig template:
     * ```twig
     * <img src="..." alt="..." {{ image.htmlDimensions|raw }}>
     * <!-- Will render: -->
     * <img src="..." alt="..." width="..." height="...">
     * ```
     *
     * @return string|null Returns `null` if dimensions array is itself null
     */
    public function getHtmlDimensions(): ?string
    {
        if (null !== $this->dimensions) {
            return \sprintf('width="%s" height="%s"', $this->getWidth(), $this->getHeight());
        }

        return null;
    }

    public static function default(): self
    {
        return new self();
    }

    public function isImage(): bool
    {
        return in_array($this->mimeType, [
            'image/png',
            'image/webp',
            'image/svg',
            'image/jpg',
            'image/jpeg',
        ], true);
    }

    public function isAudio(): bool
    {
        return in_array($this->mimeType, [
            'audio/mp3',
            'audio/wav',
        ], true);
    }
}
