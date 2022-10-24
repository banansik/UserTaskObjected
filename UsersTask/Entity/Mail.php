<?php
declare(strict_types=1);

namespace UsersTask\Entity;

class Mail
{
    private string $recipient;
    private string $cc;
    private string $subject;
    private string $queue;

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getCc(): string
    {
        return $this->cc;
    }

    /**
     * @param string $cc
     */
    public function setCc(string $cc): void
    {
        $this->cc = $cc;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getQueue(): string
    {
        return $this->queue;
    }

    /**
     * @param string $queue
     */
    public function setQueue(string $queue): void
    {
        $this->queue = $queue;
    }
}