<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Mtvs\EloquentApproval\ApprovalStatuses;

class ApprovalBadgeColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color(
            fn(string $state) =>
            match ($state) {
                ApprovalStatuses::APPROVED => config('filament-eloquent-approval.approval_table_badge_column.color.approved'),
                ApprovalStatuses::REJECTED => config('filament-eloquent-approval.approval_table_badge_column.color.rejected'),
                ApprovalStatuses::PENDING => config('filament-eloquent-approval.approval_table_badge_column.color.pending'),
            }
        );

        $this->badge();
    }
}
