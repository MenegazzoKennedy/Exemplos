<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisparaMudancaData extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $produtoName;
    protected $nome;
    protected $visitaData;
    protected $visitaHora;
    public function __construct($produto, $nome, $data, $hora)
    {
        $this->produtoName = $produto;
        $this->nome = $nome;
        $this->visitaData = $data;
        $this->visitaHora = $hora;
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
        ->greeting('Olá '.$this->nome.'!')
        ->line('A visita ao imovél '.$this->produtoName.', ocorreu uma mudança da data do agendamento para '.$this->visitaData.', no horário de '.$this->visitaHora.".")
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
