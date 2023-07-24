<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Job;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppRecentJobItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/job/recent_job_item.html.twig')]
final class AppRecentJobItem
{
}
