<?php
namespace App\Filament\Resources\Stats\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class StatsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("label")->searchable()->sortable(),
                TextColumn::make("value"),
                TextColumn::make("icon"),
                IconColumn::make("is_active")->boolean()->label("Active"),
                TextColumn::make("sort_order")->sortable()->label("Order"),
            ])
            ->defaultSort("sort_order")
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
