<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="tblproductdata", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{

    private const DATE_DISCONTINUED = "dtmDiscontinued";
    private const COST = "Cost in GBP";
    private const STOCK = "Stock";
    private const PRODUCT_CODE = "Product Code";
    private const PRODUCT_NAME = "Product Name";
    private const PRODUCT_DESCRIPTION = "Product Description";

    /**
     * @var int
     *
     * @ORM\Column(name="intProductDataId", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private string $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private string $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private string $productCode;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private \DateTime $dtmAdded;

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
     * @ORM\Column(name="floatproductprice", type="float")
     */
    private float $productPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="intproductstock", type="integer")
     */
    private int $productStock;

    public function __construct()
    {
    }

    protected function fillProduct(array $productData): void
    {
        $this->productName = $productData[self::PRODUCT_NAME];
        $this->productDesc = $productData[self::PRODUCT_DESCRIPTION];
        $this->productCode = $productData[self::PRODUCT_CODE];
        $this->dateDiscontinued = $productData[self::DATE_DISCONTINUED];
        $this->productPrice = $productData[self::COST];
        $this->productStock = $productData[self::STOCK];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public static function withProductData(array $productData): Product
    {
        $product = new self();
        $product->fillProduct($productData);
        return $product;
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

    /**
     * @ORM\PrePersist()
     */
    public function setDtmAddedValue(): void
    {
        $this->dtmAdded = new \DateTime();
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

    /**
     * @ORM\PrePersist()
     */
    public function setStmTimeStampInitial(): void
    {
        $this->stmTimeStamp = new \DateTime();
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

    public function setProductCode(string $productCode): self
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function setDtmAdded(?\DateTimeInterface $dtmAdded): self
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

}
