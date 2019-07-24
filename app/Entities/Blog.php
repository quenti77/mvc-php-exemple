<?php

namespace App\Entities;

use DateTime;
use Exception;
use Mvc\Databases\HydrateTrait;

/**
 * Class Blog
 * @package App\Entities
 */
class Blog
{
    use HydrateTrait;

    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var string $slug */
    private $slug;

    /** @var string $content */
    private $content;

    /** @var DateTime */
    private $createdAt;

    /**
     * Blog constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|string $createdAt
     * @throws Exception
     */
    public function setCreatedAt($createdAt): void
    {
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }

        $this->createdAt = $createdAt;
    }
}
