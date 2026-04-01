<?php
namespace App\Filament\Resources\TeamMembers\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class TeamMembersTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                ImageColumn::make("photo")->circular(),
                TextColumn::make("name")->searchable()->sortable(),
                TextColumn::make("role")->sortable(),
                TextColumn::make("department")->badge(),
                IconColumn::make("show_on_site")->boolean()->label("On Site"),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
