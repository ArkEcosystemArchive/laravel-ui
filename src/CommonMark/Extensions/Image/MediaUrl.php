<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

final class MediaUrl
{
    private ?string $type = null;

    private ?string $id = null;

    /**
     * YouTubeUrl constructor.
     *
     * @param string|null $type
     * @param string|null $id
     */
    public function __construct(?string $type, ?string $id)
    {
        $this->type = $type;
        $this->id   = $id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isSimpleCast(): bool
    {
        return $this->type === 'simplecast';
    }

    /**
     * @return bool
     */
    public function isTwitter(): bool
    {
        return $this->type === 'twitter';
    }

    /**
     * @return bool
     */
    public function isYouTube(): bool
    {
        return $this->type === 'youtube';
    }
}
