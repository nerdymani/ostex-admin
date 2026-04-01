<?php
namespace App\Filament\Resources\ContactInquiries\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
class ContactInquiriesTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("name")->searchable()->sortable(),
                TextColumn::make("email")->searchable(),
                TextColumn::make("type")->badge(),
                TextColumn::make("status")->badge()
                    ->color(fn (string $state): string => match($state) { "new" => "danger", "read" => "warning", "replied" => "success", default => "gray" }),
                TextColumn::make("created_at")->dateTime()->sortable()->label("Received"),
            ])
            ->defaultSort("created_at", "desc")
            ->filters([SelectFilter::make("status")->options(["new"=>"New","read"=>"Read","replied"=>"Replied"])])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
