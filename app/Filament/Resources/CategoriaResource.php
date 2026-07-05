<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriaResource\Pages;
use App\Models\Categoria;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriaResource extends Resource
{
    public static function can(\UnitEnum|string $action, ?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        $actionStr = $action instanceof \UnitEnum ? $action->name : $action;
        $permissionMap = [
            'viewAny' => 'categoria.list',
            'create' => 'categoria.create',
            'update' => 'categoria.edit',
            'delete' => 'categoria.delete',
            'view' => 'categoria.list',
        ];

        return auth()->user()?->can($permissionMap[$actionStr] ?? 'categoria.list') ?? false;
    }

    protected static ?string $model = Categoria::class;

    protected static ?string $slug = 'categorias';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Menú';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'categoría';

    protected static ?string $pluralModelLabel = 'Categorías';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('orden')
                    ->label('Orden')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Posición en el menú: menor número sale primero.'),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(2)
                    ->maxLength(255)
                    ->columnSpanFull(),
                FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->disk('public')
                    ->directory('categorias')
                    ->imageEditor()
                    ->columnSpanFull(),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true)
                    ->helperText('Una categoría inactiva oculta todos sus productos del menú.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('orden')
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
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('productos_count')
                    ->label('Productos')
                    ->counts('productos')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->toggleable(),
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
                TernaryFilter::make('activo')
                    ->label('Estado')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas')
                    ->placeholder('Todas'),
            ])
            ->reorderableColumns()
            ->actions([
                ViewAction::make()
                    ->modalWidth('2xl'),
                EditAction::make()
                    ->modalWidth('2xl'),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategorias::route('/'),
        ];
    }
}
