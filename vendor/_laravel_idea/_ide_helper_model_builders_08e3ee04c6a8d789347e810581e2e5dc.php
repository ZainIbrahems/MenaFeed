<?php //443c4257c9d27ff6f633822e4c37e9ce
/** @noinspection all */

namespace LaravelIdea\Helper\TCG\Voyager\Tests {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    use TCG\Voyager\Tests\ActuallyTranslatableModel;
    use TCG\Voyager\Tests\NotTranslatableModel;
    use TCG\Voyager\Tests\StillNotTranslatableModel;
    use TCG\Voyager\Tests\TranslatableModel;

    /**
     * @method ActuallyTranslatableModel|null getOrPut($key, $value)
     * @method ActuallyTranslatableModel|$this shift(int $count = 1)
     * @method ActuallyTranslatableModel|null firstOrFail($key = null, $operator = null, $value = null)
     * @method ActuallyTranslatableModel|$this pop(int $count = 1)
     * @method ActuallyTranslatableModel|null pull($key, $default = null)
     * @method ActuallyTranslatableModel|null last(callable $callback = null, $default = null)
     * @method ActuallyTranslatableModel|$this random($number = null)
     * @method ActuallyTranslatableModel|null sole($key = null, $operator = null, $value = null)
     * @method ActuallyTranslatableModel|null get($key, $default = null)
     * @method ActuallyTranslatableModel|null first(callable $callback = null, $default = null)
     * @method ActuallyTranslatableModel|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method ActuallyTranslatableModel|null find($key, $default = null)
     * @method ActuallyTranslatableModel[] all()
     */
    class _IH_ActuallyTranslatableModel_C extends _BaseCollection {
        /**
         * @param int $size
         * @return ActuallyTranslatableModel[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method ActuallyTranslatableModel baseSole(array|string $columns = ['*'])
     * @method ActuallyTranslatableModel create(array $attributes = [])
     * @method _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] cursor()
     * @method ActuallyTranslatableModel|null|_IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] find($id, array|string $columns = ['*'])
     * @method _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method ActuallyTranslatableModel|_IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method ActuallyTranslatableModel|_IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] findOrFail($id, array|string $columns = ['*'])
     * @method ActuallyTranslatableModel|_IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] findOrNew($id, array|string $columns = ['*'])
     * @method ActuallyTranslatableModel first(array|string $columns = ['*'])
     * @method ActuallyTranslatableModel firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method ActuallyTranslatableModel firstOrCreate(array $attributes = [], array $values = [])
     * @method ActuallyTranslatableModel firstOrFail(array|string $columns = ['*'])
     * @method ActuallyTranslatableModel firstOrNew(array $attributes = [], array $values = [])
     * @method ActuallyTranslatableModel firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method ActuallyTranslatableModel forceCreate(array $attributes)
     * @method _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] fromQuery(string $query, array $bindings = [])
     * @method _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] get(array|string $columns = ['*'])
     * @method ActuallyTranslatableModel getModel()
     * @method ActuallyTranslatableModel[] getModels(array|string $columns = ['*'])
     * @method _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] hydrate(array $items)
     * @method ActuallyTranslatableModel make(array $attributes = [])
     * @method ActuallyTranslatableModel newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|ActuallyTranslatableModel[]|_IH_ActuallyTranslatableModel_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|ActuallyTranslatableModel[]|_IH_ActuallyTranslatableModel_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method ActuallyTranslatableModel sole(array|string $columns = ['*'])
     * @method ActuallyTranslatableModel updateOrCreate(array $attributes, array $values = [])
     * @method _IH_ActuallyTranslatableModel_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_ActuallyTranslatableModel_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_ActuallyTranslatableModel_QB extends _BaseBuilder {}

    /**
     * @method NotTranslatableModel|null getOrPut($key, $value)
     * @method NotTranslatableModel|$this shift(int $count = 1)
     * @method NotTranslatableModel|null firstOrFail($key = null, $operator = null, $value = null)
     * @method NotTranslatableModel|$this pop(int $count = 1)
     * @method NotTranslatableModel|null pull($key, $default = null)
     * @method NotTranslatableModel|null last(callable $callback = null, $default = null)
     * @method NotTranslatableModel|$this random($number = null)
     * @method NotTranslatableModel|null sole($key = null, $operator = null, $value = null)
     * @method NotTranslatableModel|null get($key, $default = null)
     * @method NotTranslatableModel|null first(callable $callback = null, $default = null)
     * @method NotTranslatableModel|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method NotTranslatableModel|null find($key, $default = null)
     * @method NotTranslatableModel[] all()
     */
    class _IH_NotTranslatableModel_C extends _BaseCollection {
        /**
         * @param int $size
         * @return NotTranslatableModel[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method NotTranslatableModel baseSole(array|string $columns = ['*'])
     * @method NotTranslatableModel create(array $attributes = [])
     * @method _IH_NotTranslatableModel_C|NotTranslatableModel[] cursor()
     * @method NotTranslatableModel|null|_IH_NotTranslatableModel_C|NotTranslatableModel[] find($id, array|string $columns = ['*'])
     * @method _IH_NotTranslatableModel_C|NotTranslatableModel[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method NotTranslatableModel|_IH_NotTranslatableModel_C|NotTranslatableModel[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method NotTranslatableModel|_IH_NotTranslatableModel_C|NotTranslatableModel[] findOrFail($id, array|string $columns = ['*'])
     * @method NotTranslatableModel|_IH_NotTranslatableModel_C|NotTranslatableModel[] findOrNew($id, array|string $columns = ['*'])
     * @method NotTranslatableModel first(array|string $columns = ['*'])
     * @method NotTranslatableModel firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method NotTranslatableModel firstOrCreate(array $attributes = [], array $values = [])
     * @method NotTranslatableModel firstOrFail(array|string $columns = ['*'])
     * @method NotTranslatableModel firstOrNew(array $attributes = [], array $values = [])
     * @method NotTranslatableModel firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method NotTranslatableModel forceCreate(array $attributes)
     * @method _IH_NotTranslatableModel_C|NotTranslatableModel[] fromQuery(string $query, array $bindings = [])
     * @method _IH_NotTranslatableModel_C|NotTranslatableModel[] get(array|string $columns = ['*'])
     * @method NotTranslatableModel getModel()
     * @method NotTranslatableModel[] getModels(array|string $columns = ['*'])
     * @method _IH_NotTranslatableModel_C|NotTranslatableModel[] hydrate(array $items)
     * @method NotTranslatableModel make(array $attributes = [])
     * @method NotTranslatableModel newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|NotTranslatableModel[]|_IH_NotTranslatableModel_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|NotTranslatableModel[]|_IH_NotTranslatableModel_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method NotTranslatableModel sole(array|string $columns = ['*'])
     * @method NotTranslatableModel updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_NotTranslatableModel_QB extends _BaseBuilder {}

    /**
     * @method StillNotTranslatableModel|null getOrPut($key, $value)
     * @method StillNotTranslatableModel|$this shift(int $count = 1)
     * @method StillNotTranslatableModel|null firstOrFail($key = null, $operator = null, $value = null)
     * @method StillNotTranslatableModel|$this pop(int $count = 1)
     * @method StillNotTranslatableModel|null pull($key, $default = null)
     * @method StillNotTranslatableModel|null last(callable $callback = null, $default = null)
     * @method StillNotTranslatableModel|$this random($number = null)
     * @method StillNotTranslatableModel|null sole($key = null, $operator = null, $value = null)
     * @method StillNotTranslatableModel|null get($key, $default = null)
     * @method StillNotTranslatableModel|null first(callable $callback = null, $default = null)
     * @method StillNotTranslatableModel|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method StillNotTranslatableModel|null find($key, $default = null)
     * @method StillNotTranslatableModel[] all()
     */
    class _IH_StillNotTranslatableModel_C extends _BaseCollection {
        /**
         * @param int $size
         * @return StillNotTranslatableModel[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method StillNotTranslatableModel baseSole(array|string $columns = ['*'])
     * @method StillNotTranslatableModel create(array $attributes = [])
     * @method _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] cursor()
     * @method StillNotTranslatableModel|null|_IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] find($id, array|string $columns = ['*'])
     * @method _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method StillNotTranslatableModel|_IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method StillNotTranslatableModel|_IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] findOrFail($id, array|string $columns = ['*'])
     * @method StillNotTranslatableModel|_IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] findOrNew($id, array|string $columns = ['*'])
     * @method StillNotTranslatableModel first(array|string $columns = ['*'])
     * @method StillNotTranslatableModel firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method StillNotTranslatableModel firstOrCreate(array $attributes = [], array $values = [])
     * @method StillNotTranslatableModel firstOrFail(array|string $columns = ['*'])
     * @method StillNotTranslatableModel firstOrNew(array $attributes = [], array $values = [])
     * @method StillNotTranslatableModel firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method StillNotTranslatableModel forceCreate(array $attributes)
     * @method _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] fromQuery(string $query, array $bindings = [])
     * @method _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] get(array|string $columns = ['*'])
     * @method StillNotTranslatableModel getModel()
     * @method StillNotTranslatableModel[] getModels(array|string $columns = ['*'])
     * @method _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] hydrate(array $items)
     * @method StillNotTranslatableModel make(array $attributes = [])
     * @method StillNotTranslatableModel newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|StillNotTranslatableModel[]|_IH_StillNotTranslatableModel_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|StillNotTranslatableModel[]|_IH_StillNotTranslatableModel_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method StillNotTranslatableModel sole(array|string $columns = ['*'])
     * @method StillNotTranslatableModel updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_StillNotTranslatableModel_QB extends _BaseBuilder {}

    /**
     * @method TranslatableModel|null getOrPut($key, $value)
     * @method TranslatableModel|$this shift(int $count = 1)
     * @method TranslatableModel|null firstOrFail($key = null, $operator = null, $value = null)
     * @method TranslatableModel|$this pop(int $count = 1)
     * @method TranslatableModel|null pull($key, $default = null)
     * @method TranslatableModel|null last(callable $callback = null, $default = null)
     * @method TranslatableModel|$this random($number = null)
     * @method TranslatableModel|null sole($key = null, $operator = null, $value = null)
     * @method TranslatableModel|null get($key, $default = null)
     * @method TranslatableModel|null first(callable $callback = null, $default = null)
     * @method TranslatableModel|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method TranslatableModel|null find($key, $default = null)
     * @method TranslatableModel[] all()
     */
    class _IH_TranslatableModel_C extends _BaseCollection {
        /**
         * @param int $size
         * @return TranslatableModel[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method TranslatableModel baseSole(array|string $columns = ['*'])
     * @method TranslatableModel create(array $attributes = [])
     * @method _IH_TranslatableModel_C|TranslatableModel[] cursor()
     * @method TranslatableModel|null|_IH_TranslatableModel_C|TranslatableModel[] find($id, array|string $columns = ['*'])
     * @method _IH_TranslatableModel_C|TranslatableModel[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method TranslatableModel|_IH_TranslatableModel_C|TranslatableModel[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method TranslatableModel|_IH_TranslatableModel_C|TranslatableModel[] findOrFail($id, array|string $columns = ['*'])
     * @method TranslatableModel|_IH_TranslatableModel_C|TranslatableModel[] findOrNew($id, array|string $columns = ['*'])
     * @method TranslatableModel first(array|string $columns = ['*'])
     * @method TranslatableModel firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method TranslatableModel firstOrCreate(array $attributes = [], array $values = [])
     * @method TranslatableModel firstOrFail(array|string $columns = ['*'])
     * @method TranslatableModel firstOrNew(array $attributes = [], array $values = [])
     * @method TranslatableModel firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method TranslatableModel forceCreate(array $attributes)
     * @method _IH_TranslatableModel_C|TranslatableModel[] fromQuery(string $query, array $bindings = [])
     * @method _IH_TranslatableModel_C|TranslatableModel[] get(array|string $columns = ['*'])
     * @method TranslatableModel getModel()
     * @method TranslatableModel[] getModels(array|string $columns = ['*'])
     * @method _IH_TranslatableModel_C|TranslatableModel[] hydrate(array $items)
     * @method TranslatableModel make(array $attributes = [])
     * @method TranslatableModel newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|TranslatableModel[]|_IH_TranslatableModel_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|TranslatableModel[]|_IH_TranslatableModel_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method TranslatableModel sole(array|string $columns = ['*'])
     * @method TranslatableModel updateOrCreate(array $attributes, array $values = [])
     * @method _IH_TranslatableModel_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_TranslatableModel_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_TranslatableModel_QB extends _BaseBuilder {}
}
