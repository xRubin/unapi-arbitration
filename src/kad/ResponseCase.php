<?php

namespace unapi\arbitration\kad;

use DateTimeInterface;

class ResponseCase
{
    const TYPE_ADMINISTRATIVE = 1;
    const TYPE_BANKRUPTCY = 2;
    const TYPE_CIVIL = 3;

    /** @var string */
    private $id;
    /** @var string */
    private $number;
    /** @var int */
    private $type;
    /** @var string */
    private $courtName;
    /** @var DateTimeInterface */
    private $date;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ResponseCase
     */
    public function setId(string $id): ResponseCase
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return ResponseCase
     */
    public function setNumber(string $number): ResponseCase
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return ResponseCase
     */
    public function setType(int $type): ResponseCase
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCourtName(): ?string
    {
        return $this->courtName;
    }

    /**
     * @param string $courtName
     * @return ResponseCase
     */
    public function setCourtName(string $courtName): ResponseCase
    {
        $this->courtName = $courtName;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     * @return ResponseCase
     */
    public function setDate(DateTimeInterface $date): ResponseCase
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return 'https://kad.arbitr.ru/Card/' . $this->getId();
    }
}