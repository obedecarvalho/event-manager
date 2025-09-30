<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mtvs\EloquentApproval\ApprovalFactoryStates;
use Mtvs\EloquentApproval\ApprovalStatuses;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    use ApprovalFactoryStates;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start_at = fake()->dateTimeBetween(startDate:'-120 days', endDate:'+240 days');
        $end_at = date_add(clone $start_at, new DateInterval('PT1H'));

        return [
            'name' => fake()->company(),
            'description' => fake()->sentence(20),
            'is_public' => fake()->boolean(90),
            'start_at' => $start_at,
            'end_at' => $end_at,
            'latitude' => fake()->latitude(max: -21.21, min: -21.27),
            'longitude' => fake()->longitude(max: -44.965, min:-45.02),
        ];
    }

    public function withRandomApprovalState()
	{
		return $this->state(function ()
		{
            $status = fake()->randomElement([ApprovalStatuses::APPROVED, ApprovalStatuses::PENDING, ApprovalStatuses::REJECTED]);
			return $this->approvalState($status);
		});
	}
}
