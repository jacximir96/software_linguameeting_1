<?php

return [

    'create_success' => 'Account successfully created.',
    'update_success' => 'Instructor has been successfully saved.',
    'delete_success' => 'Instructor has been successfully deleted',
    'error' => [
        'on_create' => 'Sorry, there is an error creating instructor.',
        'on_update' => 'Sorry, there is an error updating instructor.',
        'on_delete' => 'Sorry, there is an error deleting instructor.',
        'not_found' => 'Sorry, there is an error updating instructor. Instructor or university not found.'
    ],
    'coordinator' => [
        'create_success' => 'Account successfully created.',
        'update_success' => 'Coordinator has been successfully saved.',
        'error' => [
            'on_create' => 'Sorry, there is an error creating coordinator.',
            'on_update' => 'Sorry, there is an error updating coordinator.',
        ]
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
    'teacher_assistant' => [
        'create_success' => 'Account successfully created.',
        'delete_success' => 'Instructor Assistant has been successfully deleted.',
        'update_success' => 'Instructor Assistant has been successfully saved.',
        'delete_from_section' => 'Instructor Assistant removed successfully.',
        'error' => [
            'on_create' => 'Sorry, there is an error creating instructor assistant.',
            'on_update' => 'Sorry, there is an error updating instructor assistant.',
            'on_delete' => 'Sorry, there is an error deleting instructor assistant.',
        ],
        'assign_instructor_to_assistant' => [
            'assign_success' => 'The instructor has been successfully assigned to the assistant.',
            'delete_success' => 'The instructor has been successfully unassigned.',
            'error' => [
                'on_assign' => 'Sorry, there is an error assign instructor.',
                'on_delete' => 'Sorry, there is an error delete instructor.',
            ]
        ]
    ]
];
