<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialDataResource\Pages;
use App\Models\FinancialData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FinancialDataImport;

class FinancialDataResource extends Resource
{
    protected static ?string $model = FinancialData::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->minLength(4)
                    ->maxLength(4)
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required()
                    ->label('Company'),
                Forms\Components\TextInput::make('sales')
                    ->label('Sales')
                    ->numeric(),
                Forms\Components\TextInput::make('cost_of_goods_sold')
                    ->label('Cost of Goods Sold')
                    ->numeric(),
                Forms\Components\TextInput::make('current_assets')
                    ->label('Current Assets')
                    ->numeric(),
                Forms\Components\TextInput::make('plant_property_equipment')
                    ->label('Plant, Property, and Equipment')
                    ->numeric(),
                Forms\Components\TextInput::make('sga_expenses')
                    ->label('SGA Expenses')
                    ->numeric(),
                Forms\Components\TextInput::make('total_assets')
                    ->label('Total Assets')
                    ->numeric(),
                Forms\Components\TextInput::make('depreciation')
                    ->label('Depreciation')
                    ->numeric(),
                Forms\Components\TextInput::make('account_receivables')
                    ->label('Account Receivables')
                    ->numeric(),
                Forms\Components\TextInput::make('long_term_debt')
                    ->label('Long Term Debt')
                    ->numeric(),
                Forms\Components\TextInput::make('current_liabilities')
                    ->label('Current Liabilities')
                    ->numeric(),
                Forms\Components\TextInput::make('working_capital')
                    ->label('Working Capital')
                    ->numeric(),
                Forms\Components\TextInput::make('cash')
                    ->label('Cash')
                    ->numeric(),
                Forms\Components\TextInput::make('current_taxes_payables')
                    ->label('Current Taxes Payables')
                    ->numeric(),
                Forms\Components\TextInput::make('depreciation_amortization')
                    ->label('Depreciation and Amortization')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Company'),
                TextColumn::make('sales')
                    ->label('Sales')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('cost_of_goods_sold')
                    ->label('Cost of Goods Sold')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('current_assets')
                    ->label('Current Assets')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('plant_property_equipment')
                    ->label('Plant, Property, and Equipment')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('total_assets')
                    ->label('Total Assets')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('cash')
                    ->label('Cash')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')), // Format Rp
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('company')
                    ->label('Company')
                    ->relationship('company', 'name'),
            ])
            ->headerActions([
                Action::make('Import')
                    ->label('Import Excel')
                    ->action(function (array $data) {
                        Excel::import(new FinancialDataImport, $data['file']);
                    })
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('Select Excel File')
                            ->disk('local')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
                                'application/vnd.ms-excel', 
                                'text/csv'
                            ])
                            ->required(),
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialData::route('/'),
            'create' => Pages\CreateFinancialData::route('/create'),
            'edit' => Pages\EditFinancialData::route('/{record}/edit'),
        ];
    }    
}
