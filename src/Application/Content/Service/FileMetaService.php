<?php

declare(strict_types=1);

namespace Application\Content\Service;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * class FileMetaService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class FileMetaService
{
    public static function getDuration(string $path): int
    {
        if (file_exists($path)) {
            $process = new Process([
                'ffprobe',
                '-v',
                'error',
                '-show_entries',
                'format=duration',
                '-of',
                'default=noprint_wrappers=1:nokey=1',
                $path,
            ]);

            try {
                $process->mustRun();

                return (int) $process->getOutput();
            } catch (ProcessFailedException $exception) {
                throw new \RuntimeException(sprintf('Impossible de récupérer la durée de la vidéo %s, %s', $path, $exception->getMessage()));
            }
        }

        return 0;
    }
}
