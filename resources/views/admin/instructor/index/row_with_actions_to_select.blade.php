<tr>

    <td colspan="8" class="">
        <input type="checkbox" name="check_all" class="check-and-uncheck-all-with-all" data-target-class="item-to-select"/>

        <p class="ms-3 p-2 rounded bg-light d-none d-inline" id="block-all">
            <span class="d-inline-block me-3 text-muted">Están seleccionados los {{$instructors->count()}} instructores de esta página.</span>
            <span class="d-inline-block text-primary">
                                ¿Seleccionar los {{$instructors->total()}} instructores del listado completo? <input type="checkbox" id="select-all" name="select_all" value="all" />
                            </span>
        </p>
    </td>
</tr>
<tr>

    <td colspan="8">

        <a href="{{route('get.admin.instructor.email.send.config_view')}}"
           title="Send mail to selected instructors"
           data-target-class="item-to-select"


           data-modal-reload="yes"
           data-reload-type="parent"
           data-modal-title='Send email'

           class="send-mail-selected-users">
            <i class="fa fa-envelope"></i> Send mail
        </a>
    </td>
</tr>
