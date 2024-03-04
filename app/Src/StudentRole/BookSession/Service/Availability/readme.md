Availability

    Carbon $date

    AvailabilitiesTimeHour (para cada rango de horas (morning, afternoon...) tiene una colección de coachFreeSlots
    
         private TimeHour $timeHour; (model)
    
        private Collection $coachFreeSlots -> CoachFreeSlots  (tiene un coach y slots libres)
                                                Coach
                                                Collection $freeSlots -> FreeSlot
                                                                            Collection $coachSchedules CoachSchedule
