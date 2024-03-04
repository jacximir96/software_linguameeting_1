jQuery(document).ready(function () {

    jQuery.ajaxSetup({cache: false});


    jQuery("#btn-clear-universities-form-search").click(function (event) {
        jQuery('#name').val('');
        jQuery('#country_id').val('');
        jQuery('#timezone_id').val('');
        jQuery('#lingro').val('');
        jQuery('#status').val('');

        //jQuery("#status option[value='0']").attr("selected", true);
        //jQuery("#example-field option[value='0']").attr("selected", true);
    });

    jQuery("#btn-clear-courses-form-search").click(function (event) {
        jQuery('#name').val('');
        jQuery('#year').val('');
        jQuery('#start_date').val('');
        jQuery('#end_date').val('');
        jQuery('#status').val('');
        jQuery('#is_lingro').val('');

        jQuery('#university_id').val('');
        jQuery('#language_id').val('');
        jQuery('#semester_id').val('');
        jQuery('#service_type_id').val('');
        jQuery('#level_id').val('');

        //jQuery("#status option[value='0']").attr("selected", true);
        //jQuery("#example-field option[value='0']").attr("selected", true);
    });

    jQuery("#btn-clear-instructors-form-search").click(function (event) {
        jQuery('#name').val('');
        jQuery('#lastname').val('');
        jQuery('#email').val('');
        jQuery('#status').val('');
        jQuery('#university_id').val('');

        jQuery('#language_id').val('');
        jQuery('#role_id').val('');

        jQuery('#university_id').selectpicker('val', '');
        jQuery('#university_id').selectpicker('refresh');

        jQuery('#course_id').selectpicker('val', '');
        jQuery('#course_id').selectpicker('refresh');
    });

    jQuery("#btn-clear-coaches-form-search").click(function (event) {
        jQuery('#name').val('');
        jQuery('#lastname').val('');
        jQuery('#email').val('');
        jQuery('#status').val('');

        jQuery('#timezone_id').val('');
        jQuery('#language_id').val('');
        jQuery('#country_id').val('');

        jQuery('#role_id').val('');
    });

    jQuery("#btn-clear-students-form-search").click(function (event) {
        jQuery('#name').val('');
        jQuery('#lastname').val('');
        jQuery('#email').val('');
        jQuery('#status').val('');

        jQuery('#university_id').selectpicker('val', '');
        jQuery('#university_id').selectpicker('refresh');

        jQuery('#course_id').selectpicker('val', '');
        jQuery('#course_id').selectpicker('refresh');

        jQuery('#lingro').val('');
        jQuery('#class_code').val('');
    });

    jQuery("#btn-clear-register-codes-form-search").click(function (event) {
        jQuery('#code').val('');
    });

    jQuery("#btn-clear-reviews-form-search").click(function (event) {
        jQuery('#student').val('');
        jQuery('#coach').val('');

        jQuery('#university_id').val('');
        jQuery('#review_option_id').val('');
        jQuery('#stars').val('');
    });


    jQuery("#btn-clear-coach-course-form-search").click(function (event) {

        jQuery('.university_id').selectpicker('val', '');
        jQuery('.university_id').selectpicker('refresh');
    });


    jQuery("#btn-clear-notification-form-search").click(function (event) {

        jQuery('#start_date').val('');
        jQuery('#end_date').val('');
        jQuery('#specific_date').val('val', '');

        jQuery('#level_id').val('');
        jQuery('#type_id').val('');
        jQuery('#type_id').empty();

        jQuery('#read_status').val('val', '');
    });

    jQuery("#review-coach-search-form").click(function (event) {

        jQuery('#university_id').val('');
        jQuery('#review_option_id').val('');
        jQuery('#stars').val('');

    });

    jQuery(document).on('change', '.schedule-period-select', function (event) {

        event.preventDefault()

        jQuery('#schedule-course-search-form').submit();
    });

});
