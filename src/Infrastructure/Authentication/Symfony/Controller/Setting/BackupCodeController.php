<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Setting;

use Application\Authentication\Command\ExportBackupCodeCommand;
use Application\Authentication\Command\GenerateBackupCodeCommand;
use Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller\AbstractController;
use Domain\Authentication\Entity\User;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackupCodeSettingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/profile/authentication/settings/backup_codes', name: 'authentication_setting_backup_codes_')]
final class BackupCodeController extends AbstractController
{
    #[Route('/regenerate', name: 'regenerate', methods: ['POST'])]
    public function regenerate(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        try {
            $this->dispatchSync(new GenerateBackupCodeCommand($user));
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('authentication_setting_security');
    }

    #[Route('/export', name: 'export', methods: ['GET', 'POST'])]
    public function export(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        try {
            /** @var string $content */
            $content = $this->getHandledResultSync(new ExportBackupCodeCommand($user));
            $response = new Response($content);
            $response->headers->set('Content-Disposition', HeaderUtils::makeDisposition(
                disposition: HeaderUtils::DISPOSITION_ATTACHMENT,
                filename: 'devscast_backup_code.txt'
            ));

            return $response;
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('authentication_setting_security');
    }
}
