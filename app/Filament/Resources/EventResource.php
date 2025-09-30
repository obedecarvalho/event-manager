<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Filament\Tables\Columns\ApprovalBadgeColumn;
use App\Filament\Tables\Columns\ApprovalIconColumn;
use App\Filament\Tables\Filters\ApprovalFilter;
use App\Models\Event;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mtvs\EloquentApproval\ApprovalScope;
use Mtvs\EloquentApproval\ApprovalStatuses;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Event');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Events');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Event');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Toggle::make('is_public')
                    ->label(__('Public'))
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\DateTimePicker::make('start_at')
                    ->required()
                    ->timezone('America/Sao_Paulo')
                    ->seconds(false),
                Forms\Components\DateTimePicker::make('end_at')
                    ->required()
                    ->seconds(false)
                    ->timezone('America/Sao_Paulo')
                    ->after('start_at'),
                Forms\Components\Select::make('categories')
                    ->relationship('categories', 'description')
                    ->required()
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                Tables\Columns\BadgeColumn::make('categories.description')
                    ->limitList(3),
                Tables\Columns\ToggleColumn::make('is_public')
                    ->label(__('Public')),
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->dateTime()
                    ->sortable(),
                /*
                Tables\Columns\IconColumn::make('approval_status')
                    ->label(__('Approval status'))
                    ->icon(fn(string $state) => 
                        match($state) {
                            ApprovalStatuses::APPROVED => 'heroicon-o-check-circle',
                            ApprovalStatuses::REJECTED => 'heroicon-o-x-circle',
                            ApprovalStatuses::PENDING => 'heroicon-o-clock',
                        }
                    )
                    ->color(fn(string $state) => 
                        match($state) {
                            ApprovalStatuses::APPROVED => 'success',
                            ApprovalStatuses::REJECTED => 'danger',
                            ApprovalStatuses::PENDING => 'warning',
                        }
                    )
                    ->tooltip(fn(string $state) => 
                        match($state) {
                            ApprovalStatuses::APPROVED => __('Approved'),
                            ApprovalStatuses::REJECTED => __('Rejected'),
                            ApprovalStatuses::PENDING => __('Pending'),
                        }
                    ),
                */
                ApprovalIconColumn::make('approval_status')
                    ->label(__('Approval status'))
                    ->alignCenter(),
                /*
                ApprovalBadgeColumn::make('approval_status')
                    ->label(__('Approval status'))
                    ->alignCenter(),
                */
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approval_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\MultiSelectFilter::make('categories')
                    ->relationship('categories', 'description')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label(__('Public'))
                    ->placeholder(__('All')),
                Tables\Filters\Filter::make('start_at')
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['start_from'] && $data['start_until']) {
                            return __('Start between') . ' ' . 
                                Carbon::parse($data['start_from'])->toFormattedDateString() . 
                                ' ' . __('and') . ' ' . 
                                Carbon::parse($data['start_until'])->toFormattedDateString();
                        }
                        if ($data['start_from']) {
                            return __('Start from') . ' ' . Carbon::parse($data['start_from'])->toFormattedDateString();
                        }
                        if ($data['start_until']) {
                            return __('Start until') . ' ' . Carbon::parse($data['start_until'])->toFormattedDateString();
                        }
                        return null;
                    })
                    ->form([
                        Forms\Components\DatePicker::make('start_from'),
                        Forms\Components\DatePicker::make('start_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_at', '>=', $date),
                            )
                            ->when(
                                $data['start_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_at', '<=', $date),
                            );
                    }),
                /*
                Tables\Filters\MultiSelectFilter::make('approval_status')
                    ->label(__('Approval status'))
                    ->options([
                        ApprovalStatuses::APPROVED => __('Approved'),
                        ApprovalStatuses::REJECTED => __('Rejected'),
                        ApprovalStatuses::PENDING => __('Pending'),
                    ]),
                */
                ApprovalFilter::make('approval_status')
                    ->multiple()
                    ->label(__('Approval status')),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
                ApprovalScope::class,
            ]);
    }
}
