<?php
namespace App\Filament\Resources\GalleryItems\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class GalleryItemsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                ImageColumn::make("image"),
                TextColumn::make("title")->searchable()->sortable(),
                TextColumn::make("category")->badge(),
                IconColumn::make("is_active")->boolean()->label("Active"),
                TextColumn::make("sort_order")->sortable()->label("Order"),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
