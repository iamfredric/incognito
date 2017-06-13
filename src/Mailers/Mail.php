<?php

namespace Incognito\Mailers;

use duncan3dc\Laravel\BladeInstance;

class Mail
{
    /**
     * @var \duncan3dc\Laravel\BladeInstance
     */
    protected $blade;

    /**
     * Mail constructor.
     *
     * @param \duncan3dc\Laravel\BladeInstance $blade
     */
    public function __construct(BladeInstance $blade = null)
    {
        $this->blade = $blade ?: view();
    }

    /**
     * @param $view
     * @param $data
     * @param $callback
     *
     * @return mixed
     */
    public static function send($view, $data, $callback)
    {
        $instance = new self();

        $view = $instance->blade->make($view, $data);

        $mail = new MailMessage;

        $mail->view($view);

        $callback($mail);

        return wp_mail($mail->getTo(), $mail->getSubject(), $mail->getView(), $mail->getHeaders());
    }

    /**
     * @param $view
     * @param $data
     *
     * @return \Illuminate\View\View
     */
    public static function render($view, $data)
    {
        $instance = new self();

        return $instance->blade->render($view, $data);
    }
}