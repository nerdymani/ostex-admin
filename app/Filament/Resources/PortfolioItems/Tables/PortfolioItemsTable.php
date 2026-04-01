<?php
namespace App\Filament\Resources\PortfolioItems\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class PortfolioItemsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("title")->searchable()->sortable()->limit(35),
                TextColumn::make("client")->searchable(),
                TextColumn::make("category")->badge(),
                IconColumn::make("is_featured")->boolean()->label("Featured"),
                TextColumn::make("completed_at")->date()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
