<?php

return [

    'thread' => [

        'create' => [
            'success' => 'Message successfully created. Cierra la ventana para continuar.',
            'error' => [
                'on_create' => 'Sorry, there is an error sending message.',
            ]
        ],
        'delete' => [
            'success' => 'Thread successfully deleted.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting thread.',
                'user_is_not_owner' => 'Sorry, no es posible eliminar el hilo, no eres el propietario del mismo.',
            ]
        ],
        'reply' => [
            'success' => 'Message successfully created.',
            'error' => [
                'on_create' => 'Sorry, there is an error sending message.',
            ]
        ],
    ],
    'message' => [
        'delete' => [
            'success' => 'Message successfully deleted.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting message.',
                'user_is_not_owner' => 'Sorry, no es posible eliminar el mensaje, no eres el propietario del mismo.',
                'message_is_not_latest' => 'Sorry, no es posible eliminar el mensaje, no es el último del hilo.'
            ]
        ],
    ]
];
