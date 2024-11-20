<?php
namespace App\Filament\Resources;

use App\Models\Shift;
use App\Models\Zone;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\ShiftResource\Pages;


class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock'; // أيقونة المورد

    public static function getNavigationLabel(): string
    {
        return __('Shifts');
    }
    
    public static function getPluralLabel(): string
    {
        return __('Shifts');
    }
    
    public static function getNavigationGroup(): ?string
    {
        return __('Zone & Shift Management');
    }
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('Name'))
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('zone_id')
                ->label(__('Zone'))
                ->options(Zone::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('type')
                ->label(__('Type'))
                ->options([
                    'morning' => __('Morning'),
                    'evening' => __('Evening'),
                    'morning_evening' => __('Morning-Evening'),
                    'evening_morning' => __('Evening-Morning'),
                ])
                ->required(),

            Forms\Components\TimePicker::make('morning_start')
                ->label(__('Morning Start'))
                ->nullable(),

            Forms\Components\TimePicker::make('morning_end')
                ->label(__('Morning End'))
                ->nullable(),

            Forms\Components\TimePicker::make('evening_start')
                ->label(__('Evening Start'))
                ->nullable(),

            Forms\Components\TimePicker::make('evening_end')
                ->label(__('Evening End'))
                ->nullable(),

            Forms\Components\TextInput::make('early_entry_time')
                ->label(__('Early Entry Time (Minutes)'))
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('last_entry_time')
                ->label(__('Last Entry Time (Minutes)'))
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('early_exit_time')
                ->label(__('Early Exit Time (Minutes)'))
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('last_time_out')
                ->label(__('Last Time Out (Minutes)'))
                ->numeric()
                ->required(),

            Forms\Components\DatePicker::make('start_date')
                ->label(__('Start Date'))
                ->required(),

            Forms\Components\TextInput::make('emp_no')
                ->label(__('Number of Employees'))
                ->numeric()
                ->required(),

            Forms\Components\Toggle::make('status')
                ->label(__('Active'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('zone.name')
                    ->label(__('Zone'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('morning_start')
                    ->label(__('Morning Start')),

                Tables\Columns\TextColumn::make('evening_start')
                    ->label(__('Evening Start')),

                Tables\Columns\BooleanColumn::make('status')
                    ->label(__('Active'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('zone_id')
                    ->label(__('Zone'))
                    ->options(Zone::all()->pluck('name', 'id')),

                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'morning' => __('Morning'),
                        'evening' => __('Evening'),
                        'morning_evening' => __('Morning-Evening'),
                        'evening_morning' => __('Evening-Morning'),
                    ]),

                SelectFilter::make('status')
                    ->label(__('Active'))
                    ->options([
                        1 => __('Active'),
                        0 => __('Inactive'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
