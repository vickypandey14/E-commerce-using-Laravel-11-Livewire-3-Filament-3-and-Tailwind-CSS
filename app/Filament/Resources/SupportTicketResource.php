<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportTicketResource\Pages;
use App\Models\SupportTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Help Desk / Tickets';

    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ticket Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->disabled()
                            ->label('Customer'),
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->disabled()
                            ->label('Subject'),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull()
                            ->label('Customer Message'),
                    ])->columns(2),

                Forms\Components\Section::make('Response & Triage')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed',
                            ])
                            ->required()
                            ->default('open')
                            ->label('Ticket Status'),
                        Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                            ])
                            ->required()
                            ->default('medium')
                            ->label('Priority Level'),
                        Forms\Components\Textarea::make('admin_reply')
                            ->rows(5)
                            ->columnSpanFull()
                            ->placeholder('Type your official support response here...')
                            ->label('Official Reply'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'open' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\TextColumn::make('admin_reply')
                    ->label('Reply Status')
                    ->badge()
                    ->color(fn ($state) => empty($state) ? 'danger' : 'success')
                    ->formatStateUsing(fn ($state) => empty($state) ? 'Pending' : 'Replied'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ]),
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ]),
                Tables\Filters\Filter::make('no_reply')
                    ->label('Pending Reply Only')
                    ->query(fn (Builder $query) => $query->where(fn ($q) => $q->whereNull('admin_reply')->orWhere('admin_reply', ''))),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->label('Reply / Manage'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSupportTickets::route('/'),
            'create' => Pages\CreateSupportTicket::route('/create'),
            'edit' => Pages\EditSupportTicket::route('/{record}/edit'),
        ];
    }
}
