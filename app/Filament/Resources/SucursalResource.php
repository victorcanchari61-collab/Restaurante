<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SucursalResource\Pages;
use App\Models\Sucursal;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SucursalResource extends Resource
{
    public static function can(\UnitEnum|string $action, ?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        $actionStr = $action instanceof \UnitEnum ? $action->name : $action;
        $permissionMap = [
            'viewAny' => 'sucursal.list',
            'create' => 'sucursal.create',
            'update' => 'sucursal.edit',
            'delete' => 'sucursal.delete',
            'view' => 'sucursal.list',
        ];

        return auth()->user()?->can($permissionMap[$actionStr] ?? 'sucursal.list') ?? false;
    }

    protected static ?string $model = Sucursal::class;

    protected static ?string $slug = 'sucursales';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Sucursal';

    protected static ?string $pluralModelLabel = 'Sucursales';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('direccion')
                    ->label('Dirección')
                    ->maxLength(255),
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->tel()
                    ->maxLength(30),
                TextInput::make('impuesto')
                    ->label('Impuesto (%)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(100)
                    ->suffix('%'),
                KeyValue::make('horarios')
                    ->label('Horarios')
                    ->keyLabel('Días')
                    ->valueLabel('Horario')
                    ->addActionLabel('Agregar horario')
                    ->columnSpanFull(),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('direccion')
                    ->label('Dirección')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->toggleable(),
                TextColumn::make('impuesto')
                    ->label('Impuesto')
                    ->suffix(' %')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('users_count')
                    ->label('Usuarios')
                    ->counts('users')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('activo')
                    ->label('Estado')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas')
                    ->placeholder('Todas'),
            ])
            ->reorderableColumns()
            ->actions([
                ViewAction::make()
                    ->modalWidth('3xl'),
                EditAction::make()
                    ->modalWidth('3xl'),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSucursales::route('/'),
        ];
    }
}
