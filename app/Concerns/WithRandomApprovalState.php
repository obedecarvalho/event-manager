<?php

namespace App\Concerns;

use Mtvs\EloquentApproval\ApprovalStatuses;

trait WithRandomApprovalState
{
    public function withRandomApprovalState()
	{
		return $this->state(function ()
		{
            $status = fake()->randomElement([ApprovalStatuses::APPROVED, ApprovalStatuses::PENDING, ApprovalStatuses::REJECTED]);
			return $this->approvalState($status);
		});
	}
}
