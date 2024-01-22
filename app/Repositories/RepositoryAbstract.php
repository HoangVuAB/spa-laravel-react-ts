<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected Model $model;

    /**
     * Construct.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function create(array $attributes = []): Model
    {
        return $this->model->create($attributes);
    }

    public function insert(array $values): bool
    {
        return $this->model->insert($values);
    }

    public function update(Model|Builder $model, array $data): int|bool
    {
        return $model->update($data);
    }

    public function delete(Model|Builder $model): mixed
    {
        return $model->delete();
    }

    public function forceDelete(Model $model): ?bool
    {
        return $model->forceDelete();
    }

    public function destroy(SupportCollection|array|int|string $ids): int
    {
        return $this->model->destroy($ids);
    }

    public function find(mixed $id, array $columns = ['*']): Model|Collection|static|array|null
    {
        return $this->model->find($id, $columns);
    }

    public function findByField(mixed $field, mixed $value): ?Model
    {
        return $this->model->where($field, $value)?->first();
    }

    public function findByFields(array $conditions): ?Builder
    {
        return $this->model->where($conditions);
    }

    public function buildWhere(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     ['gender', 'male'],
        //     ['age', '>=', 18],
        //     ['salary', '<=', '1000']
        // ];
        // or
        // $conditions = [
        //     'gender' => 'male',
        //     'age' => 18,
        // ];

        return $query->where($conditions);
    }

    public function buildWhereLike(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     'name' => 'test',
        //     'email', =>, 'email'
        // ];

        foreach ($conditions as $key => $value) {
            $query = $query->where($key, 'LIKE', "%$value%");
        }

        return $query;
    }

    public function buildWhereIn(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     'age' => [25, 40, 60],
        //     'role' => [0, 1, 2]
        // ];

        foreach ($conditions as $key => $value) {
            $query = $query->whereIn($key, $value);
        }

        return $query;
    }

    public function buildWhereNotIn(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     'age' => [25, 40, 60],
        //     'role' => [0, 1, 2]
        // ];

        foreach ($conditions as $key => $value) {
            $query = $query->whereNotIn($key, $value);
        }

        return $query;
    }

    public function buildWhereBetween(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     'age' => [18, 60],
        //     'salary' => ['1000', '4000']
        // ];

        foreach ($conditions as $key => $value) {
            $query = $query->whereBetween($key, $value);
        }

        return $query;
    }

    public function buildWhereNotBetween(array $conditions, Builder|Model|null $query = null): Builder|Model
    {
        $query ??= $this->model;

        // Example
        // $conditions = [
        //     'age' => [18, 60],
        //     'salary' => ['1000', '4000']
        // ];

        foreach ($conditions as $key => $value) {
            $query = $query->whereNotBetween($key, $value);
        }

        return $query;
    }

    public function buildPagination(int $page, int $perPage, Builder|Model|null $query = null): Builder
    {
        $query ??= $this->model;
        $query = $query->forPage($page, $perPage);

        return $query;
    }

    public function getFirst(Builder|Model|null $query = null, bool $toArray = false): Model|Collection|array|null
    {
        $query ??= $this->model;

        return ! $toArray ? $query->first() : ($query->first() ? $query->first()->toArray() : null);
    }

    public function getList(Builder|Model|null $query = null, bool $toArray = false): Model|Collection|array|null
    {
        $query ??= $this->model;

        return ! $toArray ? $query->get() : ($query->get() ? $query->get()->toArray() : null);
    }

    public function getCount(?Collection $collection, int $perPage, int $page): array
    {
        $count = $collection->count();
        $totalPage = ceil($count / $perPage);

        return [
            'total_record' => $count,
            'current_page' => $page,
            'total_page' => $totalPage,
        ];
    }

    public function updateOrCreate(array $attributes, array $values = []): Model|static
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function upsert(array $data, array $keys, array $fields): bool
    {
        return $this->model->upsert($data, $keys, $fields);
    }
}
