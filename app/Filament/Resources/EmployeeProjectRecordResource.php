<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeProjectRecordResource\Pages;
use App\Models\EmployeeProjectRecord;
use App\Models\Employee;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class EmployeeProjectRecordResource extends Resource
{
    protected static ?string $model = EmployeeProjectRecord::class;

    public static function getNavigationLabel(): string
    {
        return __('Employee Project Records');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Employee Management');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label(__('Employee'))
                ->options(Employee::all()->pluck('first_name', 'id'))
                ->searchable()
                ->required(),
            
            Select::make('project_id')
                ->label(__('Project'))
                ->options(Project::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
            
            DatePicker::make('start_date')
                ->label(__('Start Date'))
                ->required(),
            
            DatePicker::make('end_date')
                ->label(__('End Date')),
            
            Toggle::make('status')
                ->label(__('Status')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('employee.first_name')
                ->label(__('Employee'))
                ->sortable()
                ->searchable(),

            TextColumn::make('project.name')
                ->label(__('Project'))
                ->sortable()
                ->searchable(),

            TextColumn::make('start_date')
                ->label(__('Start Date'))
                ->date(),

            TextColumn::make('end_date')
                ->label(__('End Date'))
                ->date(),

            BooleanColumn::make('status')
                ->label(__('Status'))
                ->sortable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployeeProjectRecords::route('/'),
            'create' => Pages\CreateEmployeeProjectRecord::route('/create'),
            'edit' => Pages\EditEmployeeProjectRecord::route('/{record}/edit'),
        ];
    }
}