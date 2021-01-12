<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="tblproductdata", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity(repositoryClass="ProducRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="intProductDataId", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $productCode;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $dtmAdded;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $dateDiscontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $stmTimeStamp = 'CURRENT_TIMESTAMP';

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $productPrice;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $productStock;

    public function __construct(string $productName, string $productDesc, string $productCode, \DateTimeInterface $dtmAdded,
                                \DateTimeInterface $dateDiscontinued, \DateTimeInterface $stmTimeStamp, float $productPrice,
                                int $productStock)
    {
        $this->productName = $productName;
        $this->productDesc = $productDesc;
        $this->productCode = $productCode;
        $this->dtmAdded = $dtmAdded;
        $this->dateDiscontinued = $dateDiscontinued;
        $this->stmTimeStamp = $stmTimeStamp;
        $this->productPrice = $productPrice;
        $this->productStock = $productStock;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDesc(): ?string
    {
        return $this->productDesc;
    }

    public function setProductDesc(string $productDesc): self
    {
        $this->productDesc = $productDesc;
        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function getDtmAdded(): ?\DateTimeInterface
    {
        return $this->dtmAdded;
    }

    public function getDateDiscontinued(): ?\DateTimeInterface
    {
        return $this->dateDiscontinued;
    }

    public function setDateDiscontinued(?\DateTimeInterface $dateDiscontinued): self
    {
        $this->dateDiscontinued = $dateDiscontinued;

        return $this;
    }

    public function getStmTimeStamp(): ?\DateTimeInterface
    {
        return $this->stmTimeStamp;
    }

    public function setStmTimeStamp(\DateTimeInterface $stmTimeStamp): self
    {
        $this->stmTimeStamp = $stmTimeStamp;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductStock(): ?int
    {
        return $this->productStock;
    }

    public function setProductStock(int $productStock): self
    {
        $this->productStock = $productStock;

        return $this;
    }


}
