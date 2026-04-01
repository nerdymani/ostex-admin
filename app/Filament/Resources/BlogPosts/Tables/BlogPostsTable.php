<?php
namespace App\Filament\Resources\BlogPosts\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
class BlogPostsTable {
    public static function configure(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make("title")->searchable()->sortable()->limit(40),
                TextColumn::make("category")->badge(),
                TextColumn::make("status")->badge()
                    ->color(fn (string $state): string => match($state) { "published" => "success", default => "gray" }),
                TextColumn::make("published_at")->date()->sortable(),
                IconColumn::make("is_featured")->boolean()->label("Featured"),
            ])
            ->filters([SelectFilter::make("status")->options(["draft"=>"Draft","published"=>"Published"])])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
