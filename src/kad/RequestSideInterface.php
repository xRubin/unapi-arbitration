<?php

namespace unapi\arbitration\kad;

interface RequestSideInterface
{
    const TYPE_ANY = -1;
    const TYPE_PLAINTIFF = 0; // Истец
    const TYPE_RESPONDENT = 1; // Ответчик
    const TYPE_THIRD_PERSON = 2; // Третье лицо
    const TYPE_OTHER_PERSON = 3; // Иное лицо

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getType(): int;

    /**
     * @return bool
     */
    public function isExactMatch(): bool;
}