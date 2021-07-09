<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operation_type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $operation_name;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $operation_amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $operation_date;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationType(): ?string
    {
        return $this->operation_type;
    }

    public function setOperationType(string $operation_type): self
    {
        $this->operation_type = $operation_type;

        return $this;
    }

    public function getOperationName(): ?string
    {
        return $this->operation_name;
    }

    public function setOperationName(string $operation_name): self
    {
        $this->operation_name = $operation_name;

        return $this;
    }

    public function getOperationAmount(): ?float
    {
        return $this->operation_amount;
    }

    public function setOperationAmount(float $operation_amount): self
    {
        $this->operation_amount = $operation_amount;

        return $this;
    }

    public function getOperationDate(): ?\DateTimeInterface
    {
        return $this->operation_date;
    }

    public function setOperationDate(\DateTimeInterface $operation_date): self
    {
        $this->operation_date = $operation_date;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
