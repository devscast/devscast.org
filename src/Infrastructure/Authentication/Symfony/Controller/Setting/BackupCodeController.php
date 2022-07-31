<?php

declare(strict_types=1);

namespace Infrastructure\Authentication\Symfony\Controller\Setting;

use Application\Authentication\Command\ExportBackupCodeCommand;
use Application\Authentication\Command\GenerateBackupCodeCommand;
use Domain\Authentication\Entity\User;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackupCodeSettingController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[Route('/profile/authentication/settings/backup_codes', name: 'authentication_setting_backup_codes_')]
final class BackupCodeController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (empty($user->getBackupCodes())) {
            try {
                $this->dispatchSync(new GenerateBackupCodeCommand($user));
            } catch (\Throwable $e) {
                $this->addSafeMessageExceptionFlash($e);
            }
        }

        return $this->render(
            view: 'domain/authentication/setting/backup_code.html.twig',
            parameters: [
                'codes' => $user->getBackupCodes(),
            ]
        );
    }

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

        return $this->redirectSeeOther('authentication_setting_backup_codes_index');
    }

    #[Route('/export', name: 'export', methods: ['GET', 'POST'])]
    public function export(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        try {
            $envelope = $this->dispatchSync(new ExportBackupCodeCommand($user));

            /** @var HandledStamp $stamp */
            $stamp = $envelope?->last(HandledStamp::class);

            $response = new Response(strval($stamp->getResult()));
            $response->headers->set('Content-Disposition', HeaderUtils::makeDisposition(
                disposition: HeaderUtils::DISPOSITION_ATTACHMENT,
                filename: 'devscast_backup_code.txt'
            ));

            return $response;
        } catch (\Throwable $e) {
            $this->addSafeMessageExceptionFlash($e);
        }

        return $this->redirectSeeOther('authentication_setting_backup_codes_index');
    }
}
