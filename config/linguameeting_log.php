<?php

return [

    'activity' => [
        'keys' => [
            'login' => 'activity.login',
            'course' => [
                'send_documentation' => 'activity.course.send_documentation',
                'makeup' => [
                    'create' => 'activity.course.makeup_created',
                ]
            ],
            'section' => [
                'send_documentation' => 'activity.section.send_documentation',
                'makeup' => [
                    'create' => 'activity.section.makeup_created',
                ]
            ],
            'student' => [
                'course' => [
                    'change' => 'activity.student.course.change',
                    'refund' => 'activity.student.course.refund',
                ],
                'create' => 'activity.student.create',
                'makeup' => [
                    'buy' =>  'activity.student.makeup.buy',
                ],
                'section' => [
                    'change' => 'activity.student.section.change',
                ],
                'sessions' => [
                    'book' => 'activity.student.sessions.book',
                    'last_minute' => 'activity.student.sessions.last_minute',
                    'extra_session' => 'activity.student.sessions.extra_session',
                    'cancel' => 'activity.student.sessions.cancel',
                    'reschedule' => 'activity.student.sessions.reschedule',
                    'join' => 'activity.student.sessions.join',
                    'makeup' => [
                        'use_in_session' => 'activity.student.sessions.makeup.use_in_session',
                    ]
                ]
            ],
            'user' => [
                'login' => 'activity.user.login',
                'logout' => 'activity.user.logout',
            ]
        ]
    ],
];
