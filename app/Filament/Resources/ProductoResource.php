<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductoResource\Pages;
use App\Models\Producto;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductoResource extends Resource
{
    public static function can(\UnitEnum|string $action, ?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        $actionStr = $action instanceof \UnitEnum ? $action->name : $action;
        $permissionMap = [
            'viewAny' => 'producto.list',
            'create' => 'producto.create',
            'update' => 'producto.edit',
            'delete' => 'producto.delete',
            'view' => 'producto.list',
        ];

        return auth()->user()?->can($permissionMap[$actionStr] ?? 'producto.list') ?? false;
    }

    protected static ?string $model = Producto::class;

    protected static ?string $slug = 'productos';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static string|\UnitEnum|null $navigationGroup = 'Menú';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'producto';

    protected static ?string $pluralModelLabel = 'Productos';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'plato' => 'Plato',
                        'bebida' => 'Bebida',
                        'combo' => 'Combo',
                    ])
                    ->default('plato')
                    ->required(),
                TextInput::make('precio')
                    ->label('Precio base')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step('0.01')
                    ->helperText('Puede tener un precio distinto por sucursal (vía API).'),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(2)
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->disk('public')
                    ->directory('productos')
                    ->imageEditor()
                    ->columnSpanFull(),
                Repeater::make('modificadores')
                    ->label('Modificadores (extras)')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('precio')
                            ->label('Precio extra')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step('0.01'),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Agregar modificador')
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
                ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'plato' => 'success',
                        'bebida' => 'info',
                        'combo' => 'warning',
                        default => 'gray',
                    })
                    ->toggleable(),
                TextColumn::make('precio')
                    ->label('Precio')
                    ->numeric(2)
                    ->sortable(),
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categoria')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre'),
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'plato' => 'Plato',
                        'bebida' => 'Bebida',
                        'combo' => 'Combo',
                    ]),
                TernaryFilter::make('activo')
                    ->label('Estado')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos')
                    ->placeholder('Todos'),
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
            'index' => Pages\ListProductos::route('/'),
        ];
    }
}
