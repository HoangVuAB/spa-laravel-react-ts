<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

interface RepositoryInterface
{
    public function create(array $attributes = []): Model;

    public function insert(array $values): bool;

    public function update(Model|Builder $model, array $data): int|bool;

    public function delete(Model|Builder $model): mixed;

    public function forceDelete(Model $model): ?bool;

    public function destroy(SupportCollection|array|int|string $ids): mixed;

    public function find(mixed $id, array $columns = ['*']): Model|Collection|static|array|null;

    public function findByField(mixed $field, mixed $value): Model;

    public function findByFields(array $conditions): Builder;

    public function buildWhere(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildWhereLike(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildWhereIn(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildWhereNotIn(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildWhereBetween(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildWhereNotBetween(array $conditions, Builder|Model|null $query = null): Builder|Model;

    public function buildPagination(int $page, int $perPage, Builder|Model|null $query = null): Builder|Model;

    public function getFirst(Builder|Model|null $query = null, bool $toArray = false): Model|Collection|array|null;

    public function getList(?Builder $query = null, bool $toArray = false): Model|Collection|array|null;

    public function getCount(?Collection $query, int $perPage, int $page): array;

    public function updateOrCreate(array $attributes, array $values = []): Model|static;

    public function upsert(array $data, array $keys, array $fields): bool;
}
