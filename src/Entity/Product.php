<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "api_product_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @SWG\Property(type="integer")
     * @Expose
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @SWG\Property(type="string", maxLength=50)
     * @Expose
     *
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @SWG\Property(type="string   ")
     * @Expose
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @SWG\Property(type="integer")
     * @Expose
     *
     */
    private $weight;

    /**
     * @ORM\Column(type="datetime")
     * @SWG\Property(type="datetime")
     * @Expose
     *
     */
    private $availableAt;

    /**
     * @ORM\Column(type="string", length=20)
     * @SWG\Property(type="string", maxLength=20)
     * @Expose
     *
     */
    private $ref;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAvailableAt(): ?\DateTimeInterface
    {
        return $this->availableAt;
    }

    public function setAvailableAt(\DateTimeInterface $availableAt): self
    {
        $this->availableAt = $availableAt;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }
}
