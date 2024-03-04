<b>Session Info</b>
Date: {{ toDate($session->day)}} ({{userTimezoneName()}})
Start Time: {{toTime24h($session->startTime(userTimezoneName()))}}
End Time: {{toTime24h($session->endTime(userTimezoneName()))}}
