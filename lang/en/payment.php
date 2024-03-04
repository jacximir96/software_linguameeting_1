<?php

return [

    'bookstore_code' => [
        'required_if' => 'El código es obligatorio cuando la forma de pago es Code.'
    ],
    'experience' => [
        'register' => [
            'success' => 'Thank you for your register in this Experience. Close window to continue.',
            'error' => [
                'general' => 'When create a payment for the register in experience.',
                'already_registered' => 'The user is already registered in the experience.',
                'is_paid' => 'No puedes registrarte en la experiencia de forma gratuita. Esta experiencia es de pago.'
            ],
            'mail' => [
                'subject' => 'LinguaMeeting Experiences',
             ]
        ],
        'tip' => [
            'success' => 'Thank you for your donation for the host of this Experience. Close window to continue.',
            'error' => [
                'general' => 'When create a payment for the experience.'
            ],
        ]
    ],
    'makeup' => [
        'success_one' => 'Thanks for purchase a make up. Close window to continue.',
        'success_several' => 'Thanks for purchase :number Make-Ups. Close window to continue.',

        'error' => [
            'general' => 'When create a payment for the makeup.',
            'number_makeups_excedeed' => 'No puedes comprar más de :number Make-Ups',
        ],
    ],
    'refund' => [
        'code_course' => 'To request a refund, please go to the bookstore where you purchased your code',
        'free_course' => 'This is a open course you cannot get a refund.'
    ],
    'section_code' => [
        'exists' => 'Section code not exists.',
        'exists_v2' => 'The Class ID provided does not exist.',
        'public' => [
            'register' => [
                'not_exists' => 'You must provide a valid Class ID. Contact with your university / instructor.',
            ]
        ]
    ],
    'transaction' => [
        'error' => 'Sorry, there was an error processing the payment, refresh the page and try again, if the problem persists, please contact support.',
    ]
];
