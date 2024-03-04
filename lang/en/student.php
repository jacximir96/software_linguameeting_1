<?php

return [

    'feedback' => [
        'download' => [
            'error' => 'An error occurred while downloading the file.',
        ]
    ],
    'create_success' => 'Account successfully created.',
    'update_success' => 'Student has been successfully saved.',
    'delete_success' => 'Student has been successfully deleted',
    'restore_success' => 'Student has been successfully restored.',
    'error' => [
        'on_create' => 'Sorry, there is an error creating student.',
        'on_update' => 'Sorry, there is an error updating student.',
        'on_delete' => 'Sorry, there is an error deleting student.',
        'on_restore' => 'Sorry, there is an error restoring student.',
    ],
    'calendar' => [
        'google-calendar' => [
            'download' => [
                'error' => 'An error occurred while generating google calendar file.',
            ]
        ],
    ],
    'coordinator' => [
        'assigned_successfully' => 'El student ha sido asignado correctamente. Cierra la ventana para continuar.',
        'remove_assigned_successfully' => 'El student ya no está asignado al coordinador. Cierra la ventana para continuar.',
        'student_already_assigned' => 'El student ya pertenece a otro coordinador',
        'error' => [
            'on_assign' => 'Sorry, there is an error assigning student.',
            'on_remove' => 'Sorry, there is an error removing student.',
        ],
    ],
    'enrollment' => [
        'delete' => [
            'success' => 'Enrollment has been successfully deleted.',
            'error' => [
                'on_delete' => ''
            ]
        ],
        'makeup' => [
            'create_success' => 'Makeup successfully created. Create another make-up or exit this window to continue.',
            'update_success' => 'Makeup has been successfully saved.',
            'delete_success' => 'Makeup has been successfully deleted.',
            'error' => [
                'not_deleted_has_been_used' => 'Makeup not deleted because it has already been used.',
                'on_create' => 'Sorry, there is an error creating make-up.',
                'on_update' => 'Sorry, there is an error updating make-up.',
                'on_delete' => 'Sorry, there is an error deleting make-up.',
            ]
        ],
        'extra_session' => [
            'create_success' => 'Extra session successfully created.',
            'delete_success' => 'Extra session has been successfully deleted.',
            'error' => [
                'not_deleted_has_been_used' => 'Extra session not deleted because it has already been used.',
                'on_create' => 'Sorry, there is an error creating extra session.',
                'on_delete' => 'Sorry, there is an error deleting extra session.',
            ]
        ],
        'session' => [
            'create' => [
                'create_success' => 'La sesión ha sido asignada correctamente.',
            ],
            'feedback' => [
                'create_success' => 'Feedback successfully created. Check it or close window to continue.',
                'update_success' => 'Feedback successfully updated.',
                'delete_success' => 'Feedback has been successfully deleted.',
                'error' => [
                    'on_create' => 'Sorry, there is an error creating feedback.',
                    'on_update' => 'Sorry, there is an error updating feedback.',
                    'on_delete' => 'Sorry, there is an error deleting feedback.',
                ]

            ],
            'book' => [
                'error' => [
                    'search_coach' => [
                        'general' => 'Sorry, there is an error searching coach.'
                    ]
                ]
            ],
            'last-minute' => [
                'error' => [
                    'create_session' => 'Sorry, there is an error when create session.',
                    'session_full' => 'Sorry, session is full',
                ]
            ],
            'schedule' => [
                'create' => [
                    'create_success' => 'La sessión ha sido seleccionada correctamente.',
                ],
                'error' => [
                    'general_error' => 'Sorry, there is an error when joining session.',
                ]
            ],
            'resschedule' => [
                'create' => [
                    'create_success' => 'La sessión ha sido reasignada correctamente.',
                ],
            ],
            'makeup' => [
                'create' => [
                    'create_success' => 'La make-up ha sido creada correctamente.',
                ],
                'error' => [
                    'makeup_has_recovered' => 'La sesión ya tiene make-up de recuperación asignada.'
                ]
            ],
            'extra-session' => [
                'create' => [
                    'create_success' => 'Extra Session assign succesfully.',
                ],
                'error' => [
                    '' => ''
                ]
            ],
            'join' => [
                'error' => [
                    'general_error' => 'Sorry, there is an error when joining session.',
                ]
            ]
        ],
        'status' => [
            'description' => [
                'active' => 'Active',
                'ended' => 'Ended',
                'refunded' => 'Refunded',
                'changed' => 'Changed',
            ]
        ],
    ],
    'help' => [

        'create' => [
            'success' => 'Help successfully created. Ahora puedes revisar su información y actualizarlo o cerrar la ventana para continuar.',
            'error' => [
                'on_create' => 'Sorry, there is an error creating help.',
            ]
        ],
        'update' => [
            'success' => 'Help successfully updated.',
            'error' => [
                'on_update' => 'Sorry, there is an error updating help.',
            ]
        ],
        'delete' => [
            'success' => 'Help successfully deleted.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting help.',
            ]
        ],

    ],
    'register-code' => [
        'delete_succes' => 'Register code has been successfully deleted.',
        'change_status_succes' => 'El código ha cambiado de estado correctamente.',
        'error' => [
            'on_create' => 'Sorry, there is an error creating register code.',
            'on_delete' => 'Sorry, there is an error deleting register code.',
            'on_delete_is_used' => 'El código no se puede eliminar porque está siendo utilizado.',
            'on_changing_status' => 'Sorry, there is an error changing status register code.',
        ]
    ],
    'session' => [
        'intro_session' => [
            'success' => 'Intro Session info updated successfully',
            'error' => [
                'general' => 'Sorry, there is an error updated intro session info.',
            ]
        ]
    ]
];
