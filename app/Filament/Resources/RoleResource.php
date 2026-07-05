<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    public static function can(\UnitEnum|string $action, ?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        $actionStr = $action instanceof \UnitEnum ? $action->name : $action;
        $permissionMap = [
            'viewAny' => 'role.list',
            'create' => 'role.create',
            'update' => 'role.edit',
            'delete' => 'role.delete',
            'view' => 'role.list',
        ];

        return auth()->user()?->can($permissionMap[$actionStr] ?? 'role.list') ?? false;
    }

    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Administración';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'rol';

    protected static ?string $pluralModelLabel = 'Roles';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),
                CheckboxList::make('permissions')
                    ->label('Permisos')
                    ->relationship('permissions', 'name')
                    ->columns(3)
                    ->gridDirection('row')
                    ->bulkToggleable()
                    ->searchable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('permissions_count')
                    ->label('Permisos')
                    ->counts('permissions')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderableColumns()
            ->actions([
                Action::make('permisos')
                    ->label('')
                    ->tooltip('Ver permisos')
                    ->icon('heroicon-o-key')
                    ->color('info')
                    ->modalHeading(fn (Role $record) => "Permisos del rol: {$record->name}")
                    ->modalContent(fn (Role $record) => view('filament.admin.role-permissions', [
                        'permissions' => $record->permissions->pluck('name'),
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Cerrar')
                    ->modalWidth('lg'),
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
            'index' => Pages\ListRoles::route('/'),
        ];
    }
}
