<?php

namespace App\Filament\Resources\Components;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Mtvs\EloquentApproval\ApprovalStatuses;

class RejectedTab extends Tab
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->modifyQueryUsing(
            (fn (Builder $query) => $query->where('approval_status', ApprovalStatuses::REJECTED))
        );

        $this->icon(config('filament-eloquent-approval.approval_table_tab.icon.rejected'));
    }
}
