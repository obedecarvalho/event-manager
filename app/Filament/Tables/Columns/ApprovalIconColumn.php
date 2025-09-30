<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Mtvs\EloquentApproval\ApprovalStatuses;

class ApprovalIconColumn extends IconColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(
            fn(string $state) =>
            match ($state) {
                ApprovalStatuses::APPROVED => config('filament-eloquent-approval.approval_table_icon_column.icon.approved'),
                ApprovalStatuses::REJECTED => config('filament-eloquent-approval.approval_table_icon_column.icon.rejected'),
                ApprovalStatuses::PENDING => config('filament-eloquent-approval.approval_table_icon_column.icon.pending'),
            }
        );
        $this->color(
            fn(string $state) =>
            match ($state) {
                ApprovalStatuses::APPROVED => config('filament-eloquent-approval.approval_table_icon_column.color.approved'),
                ApprovalStatuses::REJECTED => config('filament-eloquent-approval.approval_table_icon_column.color.rejected'),
                ApprovalStatuses::PENDING => config('filament-eloquent-approval.approval_table_icon_column.color.pending'),
            }
        );
        $this->tooltip(
            fn(string $state) =>
            match ($state) {
                ApprovalStatuses::APPROVED => __('Approved'),
                ApprovalStatuses::REJECTED => __('Rejected'),
                ApprovalStatuses::PENDING => __('Pending'),
            }
        );
    }
}
