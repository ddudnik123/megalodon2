<?php

namespace App\Services\v1;

use App\Models\Executor;
use App\Models\Order;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\FavoritePresenter;
use App\Repositories\ExecutorRepo;
use App\Repositories\FavoriteRepo;
use App\Services\BaseService;

class ExecutorService extends BaseService
{
    private ExecutorRepo $executorRepo;

    public function __construct() {
        $this->executorRepo = new ExecutorRepo();
    }

    public function update(array $data)
    {
        $user = auth('api')->user();

        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        $executor = $this->executorRepo->findByUserId($user->id);

        if (is_null($executor)) {
            return $this->errValidate('Вы не зарегистрированны как исполнитель');
        }

        $executor->services()->sync($data['services']);
        unset($data['services']);
        $this->executorRepo->update($user->id, $data);

        return $this->result(['executor' => (new ExecutorPresenter($this->executorRepo->info($user->id)))->edited()]);
    }

    public function updateRating(Executor $executor) : void
    {
        $ratings = $executor->rating()->get();
        
        $sumRating = 0;
        foreach ($ratings as $rating) {
            $sumRating += $rating->rate;
        }

        $countRates = $executor->rating()->count();

        $this->executorRepo->update($executor->user_id, ['rating' => round($sumRating / $countRates, 1)]);
    }

    public function indexMy()
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Ошибка авторизации');
        }

        $favorites = (new FavoriteRepo())->indexMy($user->id);

        return $this->resultCollections($favorites, FavoritePresenter::class, 'list');
    }

    public function addToFavorites(array $data)
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Ошибка авторизации');
        }

        $data['user_id'] = $user->id;

        (new FavoriteRepo())->store($data);

        return $this->ok('Исполнитель добавлен в избранные');
    }
}