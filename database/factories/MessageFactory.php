<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $ad = Ad::inRandomOrder()->with('user')->first(); // Load ad with its owner
        $otherUser = User::where('id', '!=', $ad->user_id)->inRandomOrder()->first(); // Ensure it's not the owner

        // Randomly decide who is sender and who is receiver
        $isOwnerSender = $this->faker->boolean;

        return [
            'message' => $this->faker->sentence,
            'ad_id' => $ad->id,
            'sender_id' => $isOwnerSender ? $ad->user_id : $otherUser->id,
            'receiver_id' => $isOwnerSender ? $otherUser->id : $ad->user_id,
        ];
    }
}
