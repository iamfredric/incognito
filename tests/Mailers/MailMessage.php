<?php

namespace Tests\Mailers;

class MailMessage
{
    /**
     * @var
     */
    public $to;

    /**
     * @var
     */
    public $subject;

    /**
     * @var
     */
    public $view;

    /**
     * @var
     */
    public $from;

    /**
     * @var null
     */
    public $replyTo = null;

    /**
     * @param $email
     * @param null $name
     *
     * @return $this
     */
    public function to($email, $name = null)
    {
        $this->to = "{$name} <{$email}>";

        return $this;
    }

    /**
     * @param $subject
     *
     * @return $this
     */
    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param $view
     */
    public function view($view)
    {
        $this->view = $view;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getReplyTo()
    {
        return $this->replyTo ?: $this->getFrom();
    }

    /**
     * @return string
     */
    public function getView()
    {
        return (string) $this->view;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        $headers = "Reply-To: {$this->getReplyTo()}\r\n";

        $headers .= "From: {$this->getFrom()}\r\n";

        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return $headers;
    }
}