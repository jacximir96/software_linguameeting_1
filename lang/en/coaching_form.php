<?php

return [

    'exception' => [
        'step_academic_dates_exception' => 'An error has occurred while continuing with the coaching form. Please, retry.',
        'session_no_exists' => 'An error has occurred while continuing with the coaching form. It is necessary to configure it again. Sorry for the disturbances.',
        'error_general' => 'An error has a occurred, please correct the highlighted errors or contact support@linguameeting.com',
        'students_with_sessions_to_change_weeks' => 'Sorry you cannot change the course weeks because there are students with sessions assigned and you changed the number of sessions of the course',
        'step_section_information_exception' => 'An error has occurred while continuing with the coaching form. Please, retry.',
    ],
    'session_type_blocked' => 'Sorry, you cannot update the course because there are students with sessions assigned and you changed from small groups to one and one.',
    'num_sessions_blocked' => 'Sorry, you cannot update the amount of sessions because there are students already registered.',
    'conversation_package_not_exists' => 'Sorry, number course setup not exists. Please select another number of sessions and session duration.',
    'filesize_exceeded' => 'The size of the files exceeds the established maximum.',
    'step_feedback' => [
        'course_assignment' => [
            'success' => 'Assignments successfully added.'
        ]
    ],
    'course_assignments' => [
        'placeholder' => [
            'majority_language' => [
                'name' => 'Example: La familia y las relaciones.',
                'description' => 'Example: Vas a aprender sobre la familia de tu coach y tú le contarás como es la tuya: ¿Es grande o pequeña? ¿Quiénes son sus miembros? ¿Vivís cerca unos de los otros? Luego hablaréis de alguna familia famosa en cada uno de vuestros respectivos países.'
            ],
            'minority_language' => [
                'name' => 'Example: Family and relationships.',
                'description' => 'Example: This session will be about the family and relationships. Both the student and the coach will take the opportunity to learn about the other’s family and relationships. Is your family big or small? Who are your family members? Do you live close to each other? Then you and the student will speak about a famous family in your country.'
            ],
        ]
    ],


];
