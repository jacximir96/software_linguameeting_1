<?php

return [
    'notification' => [
        'all' => [
            'success' => 'Notifications successfully updated.',
            'error' => [
                'on_update' => 'Sorry, there is an error updating all notifications.',
            ]
        ],
        'read' => [
            'success' => 'Notification successfully marked as read.',
            'error' => [
                'on_update' => 'Sorry, there is an error marking as read a notification.',
            ]
        ],

        'unread' => [
            'success' => 'Notification successfully marked as unread.',
            'error' => [
                'on_update' => 'Sorry, there is an error marking as unread a notification.',
            ]
        ],

    ],
    'collection' => [
        'tech_support' => [
            'enrollment' => [
                'deleting' => 'Error deleting enrollment: :enrollmentId',
            ],
            'payment' => [
                'error_refund' => 'Refund error: :paymentId',
            ]
        ]
    ]
];
