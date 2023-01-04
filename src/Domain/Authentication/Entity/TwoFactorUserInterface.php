<?php

declare(strict_types=1);

namespace Domain\Authentication\Entity;

use Scheb\TwoFactorBundle\Model\BackupCodeInterface as BackupCodesTwoFactor;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface as EmailTwoFactor;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleTwoFactor;

/**
 * interface TwoFactorUserInterface.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface TwoFactorUserInterface extends GoogleTwoFactor, EmailTwoFactor, BackupCodesTwoFactor
{
}
