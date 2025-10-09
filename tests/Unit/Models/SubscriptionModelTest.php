<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubscriptionModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_subscription_relationship(): void
    {
        // Test user subscription
        $user = User::factory()->create();
        $userSubscription = Subscription::factory()->for($user, 'subscribable')->create();

        $this->assertEquals($user->getKey(), $userSubscription->subscribable->getKey());

        // Test blog subscription
        $blog = Blog::factory()->create();
        $blogSubscription = Subscription::factory()->for($blog, 'subscribable')->create();

        $this->assertEquals($blog->getKey(), $blogSubscription->subscribable->getKey());

        // Reverse relationship check
        $this->assertEquals(
            $userSubscription->getKey(),
            $user->subscriptions()->first()->getKey()
        );
    }
}
