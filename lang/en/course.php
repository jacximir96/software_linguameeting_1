<?php

return [

    'update_success' => 'Course has been successfully saved.',
    'send_documentation_success' => 'Course documentation sent succesfully.',
    'error' => [
        'on_update' => 'Sorry, there is an error updating course.',
        'on_sending_documentation' => 'Sorry, there is an error sending documentation.',
    ],
    'coach' => [
        'assign' => [
            'success' => 'Coach assigned succesfully.  Assign another coach or exit window to continue.',
            'error' => [
                'on_assign' => 'Sorry, there is an error assigning coach.',
            ]
        ],
        'delete' => [
            'success' => 'Coach deleted succesfully',
            'error' => [
                'on_assign' => 'Sorry, there is an error deleting coach.',
            ]
        ]

    ],
    'makeup' => [
        'assign' => [
            'success' => 'Makeups assigned succesfully.',
            'error' => [
                'on_assign' => 'Sorry, there is an error assign make-up.',
            ]
        ]
    ],
    'session' => [
        'delete' => [
            'success' => 'Session deleted successfully.',
        ],
        'error' => [
            'on_delete' => 'Sorry, there is an error deleting session.',
        ],
    ],
    'user' => [
        'change_access_success' => 'Access has been successfully changed.',
        'error' => [
            'on_change_access' => 'Sorry, there is an error changing access.',
        ],
        'course_coordinator' => [
            'delete_success' => 'Course coordinator has been successfully deleted.',
            'change_success' => 'Course coordinator has been successfully updated.',
            'assign_multiple_courses_success' => 'Courses assigned successfulley.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting course coordinator.',
                'on_change' => 'Sorry, there is an error updating course coordinator.',
                'on_assign_multiple_courses' => 'Sorry, there is an error assigning multiple courses.',
            ],


        ],
    ]
];
