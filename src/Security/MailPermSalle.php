<?php

namespace App\Security;

use Mailjet\Client;
use Mailjet\Resources;

class MailPermSalle
{
    private string $api_key = '0045c4a14e8928459b09c927ef4ebc6d';
    private string $api_key_secret = '2522cf3a5072dfc0ba5f8239aea53df2';
    public function send($to_email, $to_name, $subject,$address): void
    {
        $mj = new Client('b2285f4722dae45259b7c5431def39f2', 'b151d0556f298a1da80ecb8274d4f678',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "thomas.devweb94@gmail.com ",
                        'Name' => "Admin Gestion-Fit"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' =>  4247802,
                    'TemplateLanguage' => true,
                    'Subject' => "Modification des permissions liées à votre contrat",
                    'Variables' => [
                        'address'=>$address,


                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}