<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialDistressResource\Pages;
use App\Filament\Resources\FinancialDistressResource\RelationManagers;
use App\Models\FinancialDistress;
use App\Models\FinancialData;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class FinancialDistressResource extends Resource
{
    protected static ?string $model = FinancialDistress::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle'; // Ikon menu Filament

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('company_id')
                    ->label('Pilih Perusahaan')
                    ->options(Company::all()->pluck('name', 'id')) // Mengambil nama perusahaan
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('year', null)) // Reset tahun jika company berubah
                    ->afterStateUpdated(fn($state, callable $set) => self::getAvailableYears($state, $set)),

                Select::make('year')
                    ->label('Pilih Tahun')
                    ->options(fn(callable $get) => self::getAvailableYears($get('company_id')))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set, callable $get) => self::loadFinancialData($get('company_id'), $state, $set)),

                TextInput::make('current_ratio')
                    ->label('Likuiditas (Current Ratio)')
                    ->numeric()
                    ->disabled(), // Field ini dihitung otomatis

                TextInput::make('debt_to_asset_ratio')
                    ->label('Leverage (Debt to Asset Ratio)')
                    ->numeric()
                    ->disabled(), // Field ini dihitung otomatis

                TextInput::make('return_on_assets')
                    ->label('Profitabilitas (Return on Assets)')
                    ->numeric()
                    ->disabled(), // Field ini dihitung otomatis

                TextInput::make('z_score')
                    ->label('Z-Score')
                    ->numeric()
                    ->disabled(), // Field ini dihitung otomatis

                TextInput::make('classification')
                    ->label('Klasifikasi')
                    ->disabled(), // Field ini dihitung otomatis
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name')->label('Perusahaan'),
                TextColumn::make('year')->label('Tahun'),
                TextColumn::make('z_score')->label('Z-Score'),
                TextColumn::make('classification')->label('Klasifikasi'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer'),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialDistresses::route('/'),
            'create' => Pages\CreateFinancialDistress::route('/create'),
            'edit' => Pages\EditFinancialDistress::route('/{record}/edit'),
        ];
    }

    /**
     * Mengambil tahun yang tersedia untuk perusahaan
     */
    private static function getAvailableYears($companyId)
    {
        if (!$companyId) {
            return [];
        }

        return FinancialData::where('company_id', $companyId)
            ->orderBy('year', 'desc')
            ->pluck('year', 'year')
            ->toArray();
    }

    /**
     * Memuat data keuangan untuk tahun yang dipilih dan menghitung Z-Score.
     */
    private static function loadFinancialData($companyId, $year, callable $set)
    {
        if ($companyId && $year) {
            $financialData = FinancialData::where('company_id', $companyId)
                ->where('year', $year)
                ->first();

            if ($financialData) {
                // Hitung Likuiditas (Current Ratio)
                $X1 = $financialData->current_assets / $financialData->current_liabilities;

                // Hitung Leverage (Debt to Asset Ratio)
                $X2 = ($financialData->current_liabilities + $financialData->long_term_debt) / $financialData->total_assets;

                // Hitung Profitabilitas (Return on Assets)
                $X3 = $financialData->net_income / $financialData->total_assets;

                // Hitung Z-Score
                $ZScore = -4.849785 - (0.770748 * $X1) + (1.651952 * $X2) - (53.04795 * $X3);

                // Klasifikasi berdasarkan Z-Score
                $classification = '';
                if ($ZScore < 1.80) {
                    $classification = 'Distress Zone';
                } elseif ($ZScore >= 1.80 && $ZScore <= 2.99) {
                    $classification = 'Grey Area';
                } else {
                    $classification = 'Non-Distress Zone';
                }

                // Set hasil perhitungan di form
                $set('current_ratio', $X1);
                $set('debt_to_asset_ratio', $X2);
                $set('return_on_assets', $X3);
                $set('z_score', $ZScore);
                $set('classification', $classification);
            } else {
                // Kosongkan field jika data tidak ditemukan
                $set('current_ratio', null);
                $set('debt_to_asset_ratio', null);
                $set('return_on_assets', null);
                $set('z_score', null);
                $set('classification', null);
            }
        }
    }
}