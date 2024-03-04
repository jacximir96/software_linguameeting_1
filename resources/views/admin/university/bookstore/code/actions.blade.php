<a href="{{route('get.admin.register_code.bookstore_request.change_status', $code)}}"
   class="{{$code->isUsed() ? 'text-success' : 'text-warning'}} me-3"
   title="{{$code->isUsed() ? 'Change status to not used' : 'Change status to used'}}">
    <i class="fa fa-exchange-alt"></i>
</a>

<a href="{{route('get.admin.register_code.code.delete', $code)}}"
   onclick="return confirm('Are you sure to remove this code?');"
   class="text-danger"
   title="Delete code">
    <i class="fa fa-times"></i>
</a>
