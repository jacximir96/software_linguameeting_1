<?php

return [
    'availability' => [

        'create' => [
            'success' => 'Availability successfully created.',
            'error' => [
                'availability_existing' => 'Availability already exists for the selected configuration.',
                'on_create' => 'Sorry, there is an error creating availability.',
            ]
        ],
        'update' => [
            'success' => 'Availability successfully updated.',
            'error' => [
                'on_update' => 'Sorry, there is an error updating availability.',
            ]
        ],
        'delete' => [
            'success' => 'Availability successfully deleted.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting availability.',
            ]
        ],

    ],
    'billing' => [
        'config' => [
            'paid_info' => [
                'create_success' => 'Incentive type successfully created. Ahora puedes revisar su contenido o cerrar la ventana para continuar.',
                'update_success' => 'Incentive type has been successfully saved.',
                'delete_success' => 'Incentive type has been successfully deleted',
                'error' => [
                    'on_create' => 'Sorry, there is an error creating incentive type.',
                    'on_update' => 'Sorry, there is an error updating incentive type.',
                    'on_delete' => 'Sorry, there is an error deleting incentive type.',
                    'on_restore' => 'Sorry, there is an error restoring incentive type.',
                ],
            ],
            'incentive_type' => [
                'create_success' => 'Incentive type successfully created. Ahora puedes revisar su contenido o cerrar la ventana para continuar.',
                'update_success' => 'Incentive type has been successfully saved.',
                'delete_success' => 'Incentive type has been successfully deleted',
                'error' => [
                    'on_create' => 'Sorry, there is an error creating incentive type.',
                    'on_update' => 'Sorry, there is an error updating incentive type.',
                    'on_delete' => 'Sorry, there is an error deleting incentive type.',
                    'on_restore' => 'Sorry, there is an error restoring incentive type.',
                ],
            ],
            'discount_type' => [
                'create_success' => 'Discount type successfully created. Ahora puedes revisar su contenido o cerrar la ventana para continuar.',
                'update_success' => 'Discount type has been successfully saved.',
                'delete_success' => 'Discount type has been successfully deleted',
                'error' => [
                    'on_create' => 'Sorry, there is an error creating discount type.',
                    'on_update' => 'Sorry, there is an error updating discount type.',
                    'on_delete' => 'Sorry, there is an error deleting discount type.',
                    'on_restore' => 'Sorry, there is an error restoring discount type.',
                ],
            ],
        ],
        'salary' => [
            'create_success' => 'Salary successfully created.',
            'update_success' => 'Salary has been successfully saved.',
            'delete_success' => 'Salary has been successfully deleted',
            'error' => [
                'on_create' => 'Sorry, there is an error creating salary.',
                'on_delete' => 'Sorry, there is an error deleting salary.',
                'on_restore' => 'Sorry, there is an error restoring salary.',
                'on_show' => 'Sorry, there is an error showing salary.',
                'on_update' => 'Sorry, there is an error updating salary.',
            ],
        ],
        'discount' => [
            'create_success' => 'Discount successfully created.',
            'update_success' => 'Discount has been successfully saved.',
            'delete_success' => 'Discount has been successfully deleted',
            'error' => [
                'on_create' => 'Sorry, there is an error creating discount.',
                'on_update' => 'Sorry, there is an error updating discount.',
                'on_delete' => 'Sorry, there is an error deleting discount.',
                'on_restore' => 'Sorry, there is an error restoring discount.',
            ],
        ],
        'incentive' => [
            'create_success' => 'Incentive successfully created.',
            'update_success' => 'Incentive has been successfully saved.',
            'delete_success' => 'Incentive has been successfully deleted',
            'error' => [
                'on_create' => 'Sorry, there is an error creating incentive.',
                'on_update' => 'Sorry, there is an error updating incentive.',
                'on_delete' => 'Sorry, there is an error deleting incentive.',
                'on_restore' => 'Sorry, there is an error restoring incentive.',
            ],
        ],
        'invoice' => [
            'create_success' => 'Invoice successfully created.',
            'update_success' => 'Invoice has been successfully saved.',
            'delete_success' => 'Invoice has been successfully deleted',
            'error' => [
                'on_create' => 'Sorry, there is an error creating invoice.',
                'on_update' => 'Sorry, there is an error updating invoice.',
                'on_delete' => 'Sorry, there is an error deleting invoice.',
                'on_delete_is_not_last' => 'No se puede eliminar la factura porque el coach tiene facturas con numeración posterior.',
                'on_restore' => 'Sorry, there is an error restoring invoice.',
                'on_download' => 'Sorry, there is an error download invoice file.',
            ],
        ],
        'info' => [
            'success' => 'Billing info successfully updated.',
            'error' => [
                'on_update' => 'An error occurred while updating billing info.',
                'not_has_info' => 'The coach does not have billing information.'
            ]
        ],
    ],
    'calendar' => [
        'google-calendar' => [
            'download' => [
                'error' => 'An error occurred while generating google calendar file.',
            ]
        ],
    ],
    'evaluation_manager' => [
        'download' => [
            'error' => 'An error occurred while downloading the file.',
        ]
    ],
    'create_success' => 'Account successfully created.',
    'update_success' => 'Coach has been successfully saved.',
    'delete_success' => 'Coach has been successfully deleted',
    'restore_success' => 'Coach has been successfully restored',
    'error' => [
        'on_create' => 'Sorry, there is an error creating coach.',
        'on_update' => 'Sorry, there is an error updating coach.',
        'on_delete' => 'Sorry, there is an error deleting coach.',
        'on_restore' => 'Sorry, there is an error restoring coach.',
        'delete_error_coach_has_pending_sessions' => 'Coach :coach no puede ser borrado porque tiene sesiones pendientes de realizar.'
    ],
    'coordinator' => [
        'assigned_successfully' => 'El coach ha sido asignado correctamente. Cierra la ventana para continuar.',
        'remove_assigned_successfully' => 'El coach ya no está asignado al coordinador. Cierra la ventana para continuar.',
        'coach_already_assigned' => 'El coach ya pertenece a otro coordinador',
        'error' => [
            'on_assign' => 'Sorry, there is an error assigning coach.',
            'on_remove' => 'Sorry, there is an error removing coach.',
        ],
    ],
    'feedback' => [

        'create' => [
            'success' => 'Feedback added successfully. You may now review the information added or close the window to continue.',
            'error' => [
                'on_create' => 'Sorry, there is an error creating feedback.',
            ]
        ],
        'update' => [
            'success' => 'Feedback successfully updated.',
            'error' => [
                'on_update' => 'Sorry, there is an error updating feedback.',
            ]
        ],
        'delete' => [
            'success' => 'Feedback successfully deleted.',
            'error' => [
                'on_delete' => 'Sorry, there is an error deleting feedback.',
            ]
        ],
        'coach_review' => [
            'mark_review' => 'Feedback updated succesfully,',
            'success' => [
                'on_create' => 'Thank you for rating your session.',
            ],
            'error' => [
                'on_create' => 'Sorry, there is an error creating review.',
            ]
        ],

    ],
    'front' => [
        'error' => [
            'on_create' => 'Sorry, there is an error creating coach from front.',
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
    'session' => [
        'change_coach' => [
            'success' => 'Coach successfully changed.',
            'error' => [
                'on_change' => 'Sorry, there is an error changing coach.',
            ]
        ]
    ]
];
