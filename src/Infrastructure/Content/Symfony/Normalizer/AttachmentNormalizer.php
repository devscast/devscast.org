<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Normalizer;

use Domain\Content\Entity\Attachment;
use Infrastructure\Shared\Image\ImageResizerUrlGenerator;
use Infrastructure\Shared\Symfony\Normalizer\AbstractNormalizer;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * class AttachmentNormalizer.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class AttachmentNormalizer extends AbstractNormalizer
{
    public function __construct(
        private readonly UploaderHelper $uploaderHelper,
        private readonly ImageResizerUrlGenerator $resizer
    ) {
    }

    /**
     * @param Attachment $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        $info = pathinfo((string) $object->getThumbnail()->getName());
        $filenameParts = explode('-', $info['filename']);
        $filenameParts = array_slice($filenameParts, 0, -1);
        $filename = implode('-', $filenameParts);
        $extension = $info['extension'] ?? '';

        return [
            'id' => $object->getId(),
            'createdAt' => $object->getCreatedAt()?->getTimestamp(),
            'name' => "{$filename}.{$extension}",
            'size' => $object->getThumbnail()->getSize(),
            'url' => $this->uploaderHelper->asset($object),
            'thumbnail' => $this->resizer->resize($this->uploaderHelper->asset($object), 250, 250),
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Attachment && 'json' === $format;
    }
}
