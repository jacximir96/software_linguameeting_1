<b>Course</b>
Name: {{$course->name}}
University: {{$course->university->name}}
Start Date: {{toDate($course->start_date)}}
End Date: {{toDate($course->end_date)}}
Type Course: {{$course->conversationPackage->sessionType->name}}
