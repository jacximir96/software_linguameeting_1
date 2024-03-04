<?php

namespace App\Src\NotificationDomain\Notification\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function markNotifications(): bool
    {

        if ($this->has('action')) {
            if ($this->action == 'mark_read' || $this->action == 'mark_unread') {
                return true;
            }
        }

        return false;
    }

    public function markRead(): bool
    {
        if ($this->has('action')) {
            if ($this->action == 'mark_read') {
                return true;
            }
        }

        return false;
    }

    public function markUnread(): bool
    {
        if ($this->has('action')) {
            if ($this->action == 'mark_unread') {
                return true;
            }
        }

        return false;
    }
}
