<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisparaCliente extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $produtoName;
    protected $clienteName;
    protected $corretorName;
    public function __construct($produto, $cliente, $corretor)
    {
        $this->produtoName = $produto;
        $this->clienteName = $cliente;
        $this->corretorName = $corretor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        return (new MailMessage)
            ->greeting('Olá '.$this->clienteName.'!')
            ->line('O corretor '.$this->corretorName.' foi alocado para a sua visita ao imovel '.$this->produtoName.'.')
            ->subject('Solicitacao de visita');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
