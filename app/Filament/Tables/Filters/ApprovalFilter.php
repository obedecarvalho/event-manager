<?php

namespace App\Filament\Tables\Filters;

use Filament\Tables\Filters\SelectFilter;
use Mtvs\EloquentApproval\ApprovalStatuses;

class ApprovalFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options([
            ApprovalStatuses::APPROVED => __('Approved'),
            ApprovalStatuses::REJECTED => __('Rejected'),
            ApprovalStatuses::PENDING => __('Pending'),
        ]);
    }
}
