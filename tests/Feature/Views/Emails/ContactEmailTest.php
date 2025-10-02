<?php

namespace Tests\Feature\Views\Emails;

use App\Livewire\Emails\ContactEmailView;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactEmailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_form_correctly()
    {
        Livewire::test(ContactEmailView::class)
            ->assertSet('fromEmail', '')
            ->assertSet('fromName', '')
            ->assertSet('comment', '')
            ->assertSeeTextInOrder([
                'Contact Email Form',
                'Your name',
                'Your email address',
                'Comment'
                ])
            ->assertSeeHtmlInOrder(['<input type="text"', 'wire:model.lazy="fromName"'])
            ->assertSeeHtmlInOrder(['<input type="text"', 'wire:model.lazy="fromEmail"'])
            ->assertSeeHtmlInOrder(['<textarea', 'wire:model.lazy="comment"', '<button']);
    }

    #[Test]
    public function it_requires_all_fields_to_be_valid()
    {
        Livewire::test(ContactEmailView::class)
            ->set('fromEmail', '')
            ->set('fromName', '')
            ->set('comment', '')
            ->call('sendEmail')
            ->assertHasErrors([
                'fromEmail' => ['The from email field is required.'],
                'fromName'  => ['The from name field is required.'],
                'comment'   => ['The comment field is required.'],
            ]);
    }

    #[Test]
    public function it_requires_a_valid_email_address()
    {
        Livewire::test(ContactEmailView::class)
            ->set('fromEmail', 'invalid-email')
            ->set('fromName', 'Test User')
            ->set('comment', 'This is a test')
            ->call('sendEmail')
            ->assertHasErrors(['fromEmail' => ['The from email field must be a valid email address.']]);
    }

    #[Test]
    public function it_requires_all_fields_to_be_valid_lengths()
    {
        $longEmail   = 'reallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallylong@emailaddress.com
';
        $longName    = 'reallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallyreallylongname';
        $longComment =  collect([
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'Really really really really really really really really really really really really really really really really',
            'long comment',
        ])->implode('');

        Livewire::test(ContactEmailView::class)
            ->set('fromEmail', $longEmail)
            ->set('fromName', $longName)
            ->set('comment', $longComment)
            ->call('sendEmail')
            ->assertHasErrors([
                'fromEmail' => ['The from email field must not be greater than 100 characters.'],
                'fromName'  => ['The from name field must not be greater than 100 characters.'],
                'comment'   => ['The comment field must not be greater than 500 characters.'],
            ]);
    }

    #[Test]
    public function it_sends_an_email_when_form_is_valid()
    {
        Mail::fake();

        config(['snappy.emails.contact_address' => 'contact@test.com']);

        Livewire::test(ContactEmailView::class)
            ->set('fromEmail', 'test@example.com')
            ->set('fromName', 'Test User')
            ->set('comment', 'This is a test message')
            ->call('sendEmail')
            ->assertSessionHas('flash', [
                'message' => 'Send contact email success',
                'type' => config('snappy.alert.success')
            ]);

        Mail::assertSent(ContactMessage::class, function ($mail) {
            return $mail->fromEmail === 'test@example.com'
                && $mail->fromName === 'Test User'
                && $mail->comment === 'This is a test message';
        });
    }

    #[Test]
    public function it_handles_email_send_failure_gracefully()
    {
        Mail::fake();

        Mail::shouldReceive('to')
            ->once()
            ->andReturnSelf();

        Mail::shouldReceive('send')
            ->once()
            ->andThrow(new \Exception('Mail failed'));

        config(['snappy.alert.failure' => 'error']);

        Livewire::test(ContactEmailView::class)
            ->set('fromEmail', 'test@example.com')
            ->set('fromName', 'Fail Test')
            ->set('comment', 'Should fail')
            ->call('sendEmail')
            ->assertSessionHas('flash', [
                'message' => 'Send contact email failed',
                'type' => config('snappy.alert.failure')
            ]);
    }
}
