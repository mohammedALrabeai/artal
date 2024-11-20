<?php
namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            // Widgets for displaying metrics, such as contract status or vacation balance
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')->label(__('First Name'))->disabled(),
            Forms\Components\TextInput::make('job_status')->label(__('Job Status'))->disabled(),
            Forms\Components\TextInput::make('vacation_balance')->label(__('Vacation Balance'))->disabled(),
            // Add more fields as needed
        ];
    }
}
