<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Course;


use App\Src\Localization\Language\Model\Language;
use App\Src\NotificationDomain\Notification\Presenter\Printer\Value;
use Illuminate\Support\Collection;

class LanguagePrinter extends FieldPrinter
{

    public function __construct (array $data){
        parent::__construct($data);
    }

    public function key(): string
    {
        return $this->data()['key'];
    }

    public function keyField(): string
    {
        return 'language_id';
    }

    public function nameField(): string
    {
        return 'Language';
    }

    public function change (string $moment):Collection{

        $changes = collect();

        if (isset($this->data()['values'][$this->keyField()])){

            $languageId = $this->data()['values'][$this->keyField()]['values'][$moment];
            $language = Language::find($languageId);

            $value = new Value($this->nameField(), $language->name);
            $changes->push($value);
        }

        return $changes;
    }
}
