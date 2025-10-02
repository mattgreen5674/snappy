<?php

namespace App\Livewire\Emails;

use App\Mail\ContactMessage;
use Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactEmailView extends Component
{
    #[Validate('required|email|max:100')]
    public string $fromEmail;
    #[Validate('required|string|max:100')]
    public string $fromName;
    #[Validate('required|string|max:500')]
    public string $comment;

    public function sendEmail(): void
    {
        $this->validate();

        try {
            Mail::to(config('snappy.emails.contact_address'))
                ->send(new ContactMessage(
                    $this->fromName,
                    $this->fromEmail,
                    $this->comment
                ));

            session()->flash('flash', ['message' => 'Send contact email success', 'type' => config('snappy.alert.success')]);

            $this->reset(); // upon success reset form input

        } catch (Exception $e) {
            info($e);
            // Add sentry logging so we can monitor errors
            session()->flash('flash', ['message' => 'Send contact email failed', 'type' => config('snappy.alert.failure')]);
        }
    }

    public function render()
    {
        return view('livewire.emails.contact-email-view');
    }
}
