<?php
namespace App\Filament\Pages;

use App\Models\Activity;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecentActivities extends Page
{
    protected static string $view = 'filament.pages.recent-activities';

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Recent Activities';
    protected static ?string $slug = 'recent-activities';

    public function getActivities()
    {
        return Activity::with('user')
            ->latest()
            ->take(10)
            ->get();
    }

    protected function getTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('activity_type')->label('Activity Type'),
                TextColumn::make('activity_details')->label('Details'),
                TextColumn::make('created_at')->label('Timestamp')->dateTime(),
            ])
            ->filters([

            ]);
    }
}
