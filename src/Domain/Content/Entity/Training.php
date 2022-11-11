<?php

declare(strict_types=1);

namespace Domain\Content\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Content\ValueObject\ContentType;

/**
 * class Training.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class Training extends Content
{
    private ?string $youtube_playlist = null;

    private ?string $links = null;

    /**
     * @var Collection<Video>
     */
    private Collection $videos;

    private int $video_count = 0;

    private int $chapter_count = 0;

    /**
     * @var Collection<TrainingChapter>
     */
    private Collection $chapters;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        parent::__construct();
    }

    public function getContentType(): ContentType
    {
        return ContentType::training();
    }

    public function getYoutubePlaylist(): ?string
    {
        return $this->youtube_playlist;
    }

    public function setYoutubePlaylist(?string $youtube_playlist): self
    {
        $this->youtube_playlist = $youtube_playlist;

        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (! $this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTraining($this);
            $this->video_count = $this->videos->count();
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            if ($video->getTraining() === $this) {
                $video->setTraining(null);
            }

            $this->video_count = $this->videos->count();
        }

        return $this;
    }

    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(TrainingChapter $chapter): self
    {
        if (! $this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setTraining($this);
            $this->chapter_count = $this->chapters->count();
        }

        return $this;
    }

    public function removeChapter(TrainingChapter $chapter): self
    {
        if ($this->chapters->removeElement($chapter)) {
            if ($chapter->getTraining() === $this) {
                $chapter->setTraining(null);
            }

            $this->chapter_count = $this->chapters->count();
        }

        return $this;
    }

    public function getVideoCount(): int
    {
        return $this->video_count;
    }

    public function setVideoCount(int $video_count): self
    {
        $this->video_count = $video_count;

        return $this;
    }

    public function getChapterCount(): int
    {
        return $this->chapter_count;
    }

    public function setChapterCount(int $chapter_count): self
    {
        $this->chapter_count = $chapter_count;

        return $this;
    }
}
