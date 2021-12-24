<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\WebhookRepository;

/**
 * @ORM\Entity(repositoryClass=WebhookRepository::class)
 */
class Webhook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $query;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $server;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $request;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $headers;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $json;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $response;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $exception;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuery(): ?array
    {
        return $this->query;
    }

    public function setQuery(?array $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getServer(): ?array
    {
        return $this->server;
    }

    public function setServer(?array $server): self
    {
        $this->server = $server;

        return $this;
    }

    public function getRequest(): ?array
    {
        return $this->request;
    }

    public function setRequest(?array $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function setHeaders(?array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getJson(): ?array
    {
        return $this->json;
    }

    public function setJson(?array $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getException(): ?string
    {
        return $this->exception;
    }

    public function setException(?string $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
