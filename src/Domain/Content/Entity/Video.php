<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

/**
 * Class Video.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Video extends Content
{
    private ?string $source_url = null;

    private ?string $timecodes = null;

    private ?Training $training = null;

    public function getSourceUrl(): ?string
    {
        return $this->source_url;
    }

    public function setSourceUrl(?string $source_url): self
    {
        $this->source_url = $source_url;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getTimecodes(): ?string
    {
        return $this->timecodes;
    }

    public function setTimecodes(?string $timecodes): self
    {
        $this->timecodes = $timecodes;

        return $this;
    }
}
