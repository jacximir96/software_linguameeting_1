<a href="{{route('get.admin.survey.show', $survey->id)}}"
   class="open-modal me-2"
   data-modal-size="modal-lg"
   data-modal-reload="yes"
   data-reload-type="parent"
   data-modal-title='Show Survey'
   title="Show Survey">
    <i class="fa fa-eye"></i>
</a>

<a href="{{route('get.admin.survey.edit', $survey->id)}}"
   class="open-modal me-2"
   data-modal-size="modal-lg"
   data-modal-reload="yes"
   data-reload-type="parent"
   data-modal-title='Edit Survey'
   title="Edit Survey">
    <i class="fa fa-edit"></i>
</a>

<a href="{{route('get.admin.survey.delete', $survey->id)}}"
   onclick="return confirm('Are you sure you want to delete this survey?');"
   title="Delete Survey">
    <i class="fa fa-times text-danger"></i>
</a>
