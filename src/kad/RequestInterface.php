<?php

namespace unapi\arbitration\kad;

use DateTimeInterface;

interface RequestInterface
{
    /**
     * @return RequestSideInterface[]
     */
    public function getSides(): array;

    /**
     * @return RequestJudgeInterface[]
     */
    public function getJudges(): array;

    /**
     * @return RequestCourtInterface[]
     */
    public function getCourts(): array;

    /**
     * @return string[]
     */
    public function getCaseNumbers(): array;

    /**
     * @return DateTimeInterface
     */
    public function getDateFrom(): ?DateTimeInterface;

    /**
     * @return DateTimeInterface
     */
    public function getDateTo(): ?DateTimeInterface;

    /**
     * @param RequestSideInterface $side
     * @return RequestInterface
     */
    public function addSide(RequestSideInterface $side): RequestInterface;

    /**
     * @param RequestJudgeInterface $judge
     * @return RequestInterface
     */
    public function addJudge(RequestJudgeInterface $judge): RequestInterface;

    /**
     * @param RequestCourtInterface $court
     * @return RequestInterface
     */
    public function addCourt(RequestCourtInterface $court): RequestInterface;

    /**
     * @param string $caseNumber
     * @return RequestInterface
     */
    public function addCaseNumber(string $caseNumber): RequestInterface;
}