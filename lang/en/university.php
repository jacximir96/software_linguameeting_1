<?php

return [

    'create_success' => 'University has been successfully created.',
    'update_success' => 'University has been successfully saved.',
    'delete_success' => 'University has been successfully deleted.',
    'restore_success' => 'University has been successfully restored.',
    'error' => [
        'on_create' => 'Sorry, there is an error creating university.',
        'on_update' => 'Sorry, there is an error updating university.',
        'on_delete' => 'Sorry, there is an error deleting university.',
        'on_restore' => 'Sorry, there is an error restoring university.',
    ],

    'bookstore' => [
        'request' => [
            'create_success' => 'Codes generated correctly.',
            'create_error' => 'Error generating the codes.',

            'not_modified_is_used' => 'The request cannot be modified or deleted because it has used code.',
        ],
        'code' => [
            'delete_success' => 'Code has been deleted successfully',
            'not_delete_error' => 'The code has not been removed because an error has occurred.',

            'not_modified_is_used' => 'The code cannot be modified because it has been used.',

            'change_status_success' => 'Code has been changed successfully',
            'not_change_status_error' => 'The code has not been modified because an error has occurred.',
        ]
    ],
    'instructor' => [
        'assign_success' => 'Instructor has been assigned to university successfully.',
        'assign_error' => 'Error assigning an instructor to a university.',
        'delete_success' => 'Instructor has been deleted to university successfully.',
        'delete_error' => 'Error deleting an instructor to a university.',
    ]
];
