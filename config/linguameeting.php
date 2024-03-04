<?php

return [
    'billing' => [
        'coach' => [
            'invoice' => [
                'detail_description' => [
                    'coaching_hours' => 'Coaching Hours. %s, %s*',
                    'from_coaches' => 'Salary from all your coaches',
                    'discounts' => 'Deductions',
                    'incentives' => 'Incentives',
                    'extra_salary' => 'Coordination/Mentoring Services',
                ]
            ]
        ]
    ],

    'conversation_guides' => [
        'external_url' => [
            'guides' => [
                'linguameeting' => [
                    \App\Src\Localization\Language\Model\Language::SPANISH_ID => 'https://www.dropbox.com/sh/wri94hapykurmbr/AAAnsFavgivFGb-3Dnb5rwMja?dl=0',
                    \App\Src\Localization\Language\Model\Language::FRENCH_ID => 'https://www.dropbox.com/sh/mj04sz2oo1yeb7r/AADdixUUskqpQdqWvRLp2Mn1a?dl=0',
                    \App\Src\Localization\Language\Model\Language::ITALIAN_ID => 'https://www.dropbox.com/sh/vthdwn7mfhbwusl/AAA8Y3fqL0T68hh5fo5t1XQ2a?dl=0',
                ],
                'lingro' => [
                    \App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide::ID_IS_CONTRASENIA => 'https://www.dropbox.com/sh/eqfbobokgrp2kel/AADfKrK44ur50YIwpZI6_3iJa?dl=0',
                    \App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide::ID_IS_PERCORSI => 'https://www.dropbox.com/sh/b9a31r3nfbw4lqg/AAAF8z1KmycVWGWSaT2sflxla?dl=0',
                    \App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide::ID_IS_PASSAPAROLA => 'https://www.dropbox.com/sh/r7mhpa0xyp09hhe/AABblIVXslysQaGt9m-jPjWaa?dl=0',
                ],
                'create_assignment' => 'https://www.dropbox.com/sh/nsm6c4gt35wtgj3/AADgxGur33W9wos5xH7eeMSra?dl=0'
            ],
        ],
    ],
    'conversation_package' => [
        'makeup' => [
            'prices' => [
                'SG' => [
                    //duration -> price in centms
                    30 => 500,
                    45 => 500,
                ],
                'O' => [
                    15 => 500,
                    30 => 1000,
                    45 => 1000
                ]
            ]
        ]
    ],
    'course' => [
        'session' => [
            'hours_limit' => [
                'cancel' => 5,
                'reschedule' => 12,
                'last_minute' => 12,
            ]
        ]
    ],
    'env' => env('APP_ENV'),
    'files' => [
        'max_upload_size_in_KB' => (3*1024),

        'folder' => [

            'attachments' => 'attachments/',
            \App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile::KEY_PATH => 'course/section/session-assignment',
            \App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile::KEY_PATH => 'university/bookstore/request',
            \App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile::KEY_PATH => 'coach-evaluation',
            \App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile::KEY_PATH => 'conversation-guide/chapter',
            \App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile::KEY_PATH => 'conversation-guide',
            \App\Src\UserDomain\ProfileImage\Model\ProfileImage::KEY_PATH => 'profile/photo',
            \App\Src\HelpDomain\IssueFile\Model\IssueFile::KEY_PATH => 'issue',
            \App\Src\CourseDomain\Section\Model\Section::KEY_PATH_INSTRUCTIONS => 'course/section/instructions',
            \App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile::KEY_PATH => 'conversation-guide/template',
            \App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile::KEY_PATH => 'experiences/',
            \App\Src\MessagingDomain\File\Model\MessageFile::KEY_PATH => 'thread/',

        ],
    ],
    'items_per_page_short' => 15,
    'items_per_page' => 20,
    'items_per_page_universties' => 50,
    'session_duration' => [15, 30, 45],
    'list' => [
        'search_form_config' => [
            'bookstore_code_searcher' => [
                'key' => 'bookstore_code_searcher',
                'fields' => ['code', 'code_university_id'],
            ],
            'bookstore_request_searcher' => [
                'key' => 'bookstore_request_searcher',
                'fields' => ['university_id'],
            ],
            'coach_searcher' => [
                'key' => 'coach_searcher',
                'fields' => ['name', 'lastname', 'email', 'status', 'timezone_id', 'language_id', 'country_id', 'role_id']
            ],
            'course_searcher' => [
                'key' => 'course_searcher',
                'fields' => ['name', 'year', 'semester_id', 'level_id', 'start_date', 'end_date', 'university_id', 'language_id', 'status', 'is_lingro', 'service_type_id']
            ],
            'instructor_searcher' => [
                'key' => 'instructor_searcher',
                'fields' => ['name', 'lastname', 'email', 'university_id', 'course_id', 'language_id', 'role_id', 'status'],
            ],
            'register_code' => [
                'key' => 'register_code',
                'fields' => ['code']
            ],
            'review_searcher' => [
                'key' => 'review_searcher',
                'fields' => ['stars', 'coach', 'student', 'university_id', 'review_option_id']
            ],
            'review_coach_searcher' => [
                'key' => 'review_coach_searcher',
                'fields' => ['university_id', 'review_option_id', 'stars', 'favorite']
            ],
            'student_searcher' => [
                'key' => 'student_searcher',
                'fields' => ['name', 'lastname', 'email', 'status', 'university_id', 'course_id', 'class_code', 'is_lingro']
            ],
            'universities_searcher' => [
                'key' => 'universities_searcher',
                'fields' => ['name', 'country_id', 'timezone_id', 'status', 'lingro']
            ],


            //coach
            'coach_course_searcher' => [
                'key' => 'coach_course_searcher',
                'fields' => ['university_id', 'course_id']
            ],
            'coach_notification_searcher' => [ //deprectaed
                'key' => 'coach_notification_searcher',
                'fields' => ['level_id', 'type_id', 'specific_date', 'start_date', 'end_date', 'read_status']
            ],
            'notification_searcher' => [
                'key' => 'notification_searcher',
                'fields' => ['level_id', 'type_id', 'specific_date', 'start_date', 'end_date', 'read_status']
            ]
        ],
        'search_specific_dates' => [
            'today' => ['key' => 'today', 'name' => 'Today',],
            'yesterday' => ['key' => 'yesterday', 'name' => 'Yesterday',],

            'current_week' => ['key' => 'current_week', 'name' => 'Current Week',],
            'last_week' => ['key' => 'last_week', 'name' => 'Last Week',],

            'current_month' => ['key' => 'current_month', 'name' => 'Current Month',],
            'last_month' => ['key' => 'last_month', 'name' => 'Last Month',],

            'current_year' => ['key' => 'current_year', 'name' => 'Current Year',],
            'last_year' => ['key' => 'last_year', 'name' => 'Last Year',],
        ],
    ],
    'login' => [
        'maxAttempts' => 5,
        'decayMinutes' => 2
    ],
    'notification' => [
        'read_status' => [
            'all' => [
                'key' => 'all',
                'name' => 'All',
                ],
            'yes' => [
                'key' => 'yes',
                'name' => 'Yes',
            ],
            'no' => [
                'key' => 'no',
                'name' => 'No',
            ],
        ]
    ],
    'session' => [
        'algorithm' => [
            'num_coaches_returned' => env('NUM_COACHES_RETURN_ALGORITHM', 3)
        ],
        'limits' => [
            'scheduled_at_least_in_hours' => 12,
            'reschedule_up_in_hours' => 5
        ],
        'rubric' => [
            'levels' => [
                'good' => [
                    'description' => 'Very Good',
                    'id' => 1,
                    'key' => 'good',
                ],
                'acceptable' => [
                    'description' => 'Acceptable',
                    'id' => 2,
                    'key' => 'acceptable',
                ],
                'not_acceptable' => [
                    'description' => 'Not Acceptable',
                    'id' => 3,
                    'key' => 'not_acceptable',
                ]
            ]
        ],
    ],
    'survey' => [
        'default' => [
            'url' => 'https://sprw.io/stt-fASvwJnGs3DAQFPRBWxtdV',
            'description' => 'General Survey'
        ]
    ],
    'canvas' => [
        'default' => [
            'url' => 'https://www.linguameeting.com/API/canvas/registerCanvas.php',
            'description' => 'Endpoint Canvas'
        ]
    ],
    'timezone' => [
        'by_default_in_experiences' => 'America/New_York',
    ],
    'url_hasheable' => env('URL_HASHEABLE', true),
    'user' => [
        'ids' => [
            'tech_support' => 1,
        ],
        'roles' => [
            'ids' => [
                'administrator' => 1,
                'manager' => 2,
                'course_manager' => 3,
                'coordinator' => 4,
                'teacher' => 5, //instructor
                'teaching_assistant' => 6,
                'coach' => 7,
                'student' => 8,
                'super_admin' => 9,
                'coach_coordinator' => 10,
                'bookstore' => 11,
                'feedback_manager' => 12,
                'experiences_manager' => 13,
                'bookstore_manager' => 14,
                'course_coordinator' => 15,
            ],
            'coach' => [
                'coach' => 7,
                'coach_coordinator' => 10,
            ],
            'instructor' => [3, 4, 5, 6, 15],
            'instructor_coordinator' => [4],
            'instructor_order' => [4,15,3,5,6],
        ],
        'status' => [
            'enabled' => \App\Src\UserDomain\Status\Service\StatusFactory::ID_ENABLED,
            'disabled' => \App\Src\UserDomain\Status\Service\StatusFactory::ID_DISABLED,
            'blocked' => \App\Src\UserDomain\Status\Service\StatusFactory::ID_BLOCKED,
            'deleted' => \App\Src\UserDomain\Status\Service\StatusFactory::ID_DELETED,
        ]
    ]
];
