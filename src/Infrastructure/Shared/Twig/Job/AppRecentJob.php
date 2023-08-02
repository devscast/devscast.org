<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Job;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppRecentJob.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/job/recent_job_list.html.twig')]
final class AppRecentJob
{
}
