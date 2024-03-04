<?php

namespace App\Src\UserDomain\User\Request;

use App\Src\Shared\Model\ValueObject\EmailContent;
use App\Src\Shared\Model\ValueObject\Id;
use App\Src\Shared\Service\IdCollection;
use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => 'required',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function buildIdsCollection(): IdCollection
    {

        $collection = new IdCollection();
        $usersIds = explode('-', $this->users_ids);

        foreach ($usersIds as $userId) {
            $id = new Id($userId);
            $collection->add($id);
        }

        return $collection;
    }

    public function buildEmail(): EmailContent
    {
        return new EmailContent($this->subject, $this->body);
    }
}
