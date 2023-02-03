<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendPushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $fcmTokens;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message,$fcmTokens)
    {
        $this->title = __('api.notification_title');
        $this->message = $message;
        $this->fcmTokens = $fcmTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->message)
            ->withPriority('high')->asMessage($this->fcmTokens);
    }


//  $url = 'https://fcm.googleapis.com/fcm/send';

//         $serverKey = 'AAAAfiKRrcA:APA91bGlCKkWNlXc7S72tP5E9nVyJV95Lg4CUOVcZvucXXw3173ywojLl6U3t3awlphy2gNGhBCVoWTi28MYJM379Zzt0V0m6VgkUAAiCSgq4sPsTqWOyqryQjTNS5wvHpw54WK_b67J';

//         $data = [
//             "registration_ids" => $fcmTokens,
//             "notification" => [
//                 "title" => $title,
//                 "body" => $message,
//                 "date" => date('H:i'),
//             ]
//         ];
//         $encodedData = json_encode($data);

//         $headers = [
//             'Authorization:key=' . $serverKey,
//             'Content-Type: application/json',
//         ];

//         $ch = curl_init();

//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//         // Disabling SSL Certificate support temporarly
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
//         // Execute post
//         $result = curl_exec($ch);
//         if ($result === FALSE) {
//             die('Curl failed: ' . curl_error($ch));
//         }
//         // Close connection
//         curl_close($ch);
//         // FCM response
//         // dd($result);



}
