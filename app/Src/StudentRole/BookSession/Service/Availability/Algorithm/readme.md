Algorithm
    private ScoreCoachCalculator $scoreCalculator;
    private SessionRepository $sessionRepository;
    private CoachesSorter $coachesSorter;

    //status
    private Collection $coachFreeSlots;
    private Filter $filter;
    private CoachesScored $allCoachesScored;
    private CoachesScored $coachesScoredWithSessionsWithGaps;


    1º) Calcular totalScore mediante ScoreCalculator
          cada calculado va a $allCoachesScored
          si tiene sesiones libres 
