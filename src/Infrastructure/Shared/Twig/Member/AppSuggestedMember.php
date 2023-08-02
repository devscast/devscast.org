<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Member;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppSuggestedMember.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/member/suggested_member_list.html.twig')]
final class AppSuggestedMember
{
}
