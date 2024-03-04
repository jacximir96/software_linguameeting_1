<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service;

use Illuminate\Support\Collection;

class FeedbackTypeWrapper
{
    private array $data;

    public function __construct(array $data)
    {

        $this->data = $data;
    }

    public function id(): int
    {
        return $this->data['id_feed'];
    }

    public function subtypes(): Collection
    {

        $subtypes = collect();

        foreach ($this->data['subtypes'] as $subtypeId => $data) {
            $subtype = new FeedbackSubtypeWrapper($data);
            $subtypes->put($subtypeId, $subtype);
        }

        return $subtypes->sortKeys();
    }
}

/*
 "id_feed" => "1"
    "subtypes" => array:4 [▼
      1 => array:4 [▼
        "suggestion" => "0"
        "id_sub_feed" => "1"
        "observation" => "1"
        "alternative_text" => ""
      ]
      2 => array:4 [▶]
      3 => array:4 [▶]
      4 => array:4 [▶]
    ]


 */
