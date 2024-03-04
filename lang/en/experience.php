<?php

return [

    'create_success' => 'Experience has been successfully created.',
    'update_success' => 'Experience has been successfully saved.',
    'delete_success' => 'Experience has been successfully deleted.',
    'error' => [
        'on_create' => 'Sorry, there is an error creating experience.',
        'on_update' => 'Sorry, there is an error updating experience.',
        'on_delete' => 'Sorry, there is an error deleting experience.',
    ],
    'comment' => [
        'user' => [
            'create_success' => 'Thank you for your comment.',
            'error' => [
                'general' => 'Lo sentimos, pero hubo un error al guardar tu comentario.'
            ]
        ],

        'public' => [
            'create_success' => 'Thank you for your comment.',
            'error' => [
                'general' => 'Lo sentimos, pero hubo un error al guardar tu comentario.'
            ]
        ],
    ],
    'tip' => [
        'error' => [
            'no_can_donate_private' => 'La experiencia no permite donaciones privaddas.',
        ]
    ],
    'register' => [

        'delete' => [
            'success' => 'Tu asistencia a la experiencia ha sido revocada correctamente.',
            'error' => [
                'register_not_found' => 'El registro en la experiencia no ha podido ser eliminado porque no ha sido encontrado.',
                'already_started' => 'No puedes revocar tu asistencia a la experiencia porque ya ha comenzado.',
                'general' => 'Lo sentimos pero no ha sido posible revocar tu asistencia a la experiencia. Ponte en contacto con el administrador del sitio.'
            ],
        ],
    ]
];
