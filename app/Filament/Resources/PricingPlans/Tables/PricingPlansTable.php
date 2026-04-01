<?php
namespace App\Filament\Resources\PricingPlans\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class PricingPlansTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("name")->searchable()->sortable(),
                TextColumn::make("price_label"),
                TextColumn::make("billing_cycle"),
                IconColumn::make("is_featured")->boolean()->label("Featured"),
                IconColumn::make("is_active")->boolean()->label("Active"),
                TextColumn::make("sort_order")->sortable()->label("Order"),
            ])
            ->defaultSort("sort_order")
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
