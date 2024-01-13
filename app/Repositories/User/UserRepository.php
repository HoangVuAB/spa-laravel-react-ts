<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\RepositoryAbstract;
use Illuminate\Contracts\Database\Eloquent\Builder as Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository extends RepositoryAbstract implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function list(array $conditions, int|string $page, int|string $perPage): Collection|array|null
    {
        $query = $this->buildWhereLike($conditions);

        $query = $this->buildPagination($page, $perPage, $query);

        return $this->getList($query);
    }

    public function getTotal(array $conditions, int|string $perPage, int|string $page): array
    {
        $query = $this->buildWhereLike($conditions);
        $collection = $this->getList($query);

        $total = $this->getCount($collection, $perPage, $page);

        return $total;
    }

    public function update(Model|Builder $model, array $data): int|bool
    {
        if (! empty($data['password']) && $model instanceof Builder) {
            $data['password'] = Hash::make($data['password']);
        }

        return $model->update($data);
    }

    public function updateByConditions(array $conditions, array $update): int|bool
    {
        $query = $this->buildWhere($conditions);
        $user = $this->update($query, $update);

        return $user;
    }

    public function findByConditions(array $conditions, bool $first = false, bool $toArray = false): Model|Collection|array|null
    {
        $query = $this->buildWhere($conditions);
        $result = $first ? $this->getFirst($query, $toArray) : $this->getList($query, $toArray);

        return $result;
    }
}
