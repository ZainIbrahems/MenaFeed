<?php //7fb8bf67ee0c962a81d7c3177cf90b3b
/** @noinspection all */

namespace LaravelIdea\Helper\TCG\Voyager\Models {

    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;
    use TCG\Voyager\Models\Category;
    use TCG\Voyager\Models\DataRow;
    use TCG\Voyager\Models\DataType;
    use TCG\Voyager\Models\Menu;
    use TCG\Voyager\Models\MenuItem;
    use TCG\Voyager\Models\Page;
    use TCG\Voyager\Models\Permission;
    use TCG\Voyager\Models\Post;
    use TCG\Voyager\Models\Role;
    use TCG\Voyager\Models\Setting;
    use TCG\Voyager\Models\Translation;
    use TCG\Voyager\Models\User;

    /**
     * @method Category|null getOrPut($key, $value)
     * @method Category|$this shift(int $count = 1)
     * @method Category|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Category|$this pop(int $count = 1)
     * @method Category|null pull($key, $default = null)
     * @method Category|null last(callable $callback = null, $default = null)
     * @method Category|$this random($number = null)
     * @method Category|null sole($key = null, $operator = null, $value = null)
     * @method Category|null get($key, $default = null)
     * @method Category|null first(callable $callback = null, $default = null)
     * @method Category|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Category|null find($key, $default = null)
     * @method Category[] all()
     */
    class _IH_Category_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Category[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Category baseSole(array|string $columns = ['*'])
     * @method Category create(array $attributes = [])
     * @method _IH_Category_C|Category[] cursor()
     * @method Category|null|_IH_Category_C|Category[] find($id, array|string $columns = ['*'])
     * @method _IH_Category_C|Category[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Category|_IH_Category_C|Category[] findOrFail($id, array|string $columns = ['*'])
     * @method Category|_IH_Category_C|Category[] findOrNew($id, array|string $columns = ['*'])
     * @method Category first(array|string $columns = ['*'])
     * @method Category firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Category firstOrCreate(array $attributes = [], array $values = [])
     * @method Category firstOrFail(array|string $columns = ['*'])
     * @method Category firstOrNew(array $attributes = [], array $values = [])
     * @method Category firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Category forceCreate(array $attributes)
     * @method _IH_Category_C|Category[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Category_C|Category[] get(array|string $columns = ['*'])
     * @method Category getModel()
     * @method Category[] getModels(array|string $columns = ['*'])
     * @method _IH_Category_C|Category[] hydrate(array $items)
     * @method Category make(array $attributes = [])
     * @method Category newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Category[]|_IH_Category_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Category[]|_IH_Category_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Category sole(array|string $columns = ['*'])
     * @method Category updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Category_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Category_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Category_QB extends _BaseBuilder {}

    /**
     * @method DataRow|null getOrPut($key, $value)
     * @method DataRow|$this shift(int $count = 1)
     * @method DataRow|null firstOrFail($key = null, $operator = null, $value = null)
     * @method DataRow|$this pop(int $count = 1)
     * @method DataRow|null pull($key, $default = null)
     * @method DataRow|null last(callable $callback = null, $default = null)
     * @method DataRow|$this random($number = null)
     * @method DataRow|null sole($key = null, $operator = null, $value = null)
     * @method DataRow|null get($key, $default = null)
     * @method DataRow|null first(callable $callback = null, $default = null)
     * @method DataRow|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method DataRow|null find($key, $default = null)
     * @method DataRow[] all()
     */
    class _IH_DataRow_C extends _BaseCollection {
        /**
         * @param int $size
         * @return DataRow[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method DataRow baseSole(array|string $columns = ['*'])
     * @method DataRow create(array $attributes = [])
     * @method _IH_DataRow_C|DataRow[] cursor()
     * @method DataRow|null|_IH_DataRow_C|DataRow[] find($id, array|string $columns = ['*'])
     * @method _IH_DataRow_C|DataRow[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method DataRow|_IH_DataRow_C|DataRow[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method DataRow|_IH_DataRow_C|DataRow[] findOrFail($id, array|string $columns = ['*'])
     * @method DataRow|_IH_DataRow_C|DataRow[] findOrNew($id, array|string $columns = ['*'])
     * @method DataRow first(array|string $columns = ['*'])
     * @method DataRow firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method DataRow firstOrCreate(array $attributes = [], array $values = [])
     * @method DataRow firstOrFail(array|string $columns = ['*'])
     * @method DataRow firstOrNew(array $attributes = [], array $values = [])
     * @method DataRow firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method DataRow forceCreate(array $attributes)
     * @method _IH_DataRow_C|DataRow[] fromQuery(string $query, array $bindings = [])
     * @method _IH_DataRow_C|DataRow[] get(array|string $columns = ['*'])
     * @method DataRow getModel()
     * @method DataRow[] getModels(array|string $columns = ['*'])
     * @method _IH_DataRow_C|DataRow[] hydrate(array $items)
     * @method DataRow make(array $attributes = [])
     * @method DataRow newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|DataRow[]|_IH_DataRow_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|DataRow[]|_IH_DataRow_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method DataRow sole(array|string $columns = ['*'])
     * @method DataRow updateOrCreate(array $attributes, array $values = [])
     * @method _IH_DataRow_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_DataRow_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_DataRow_QB extends _BaseBuilder {}

    /**
     * @method DataType|null getOrPut($key, $value)
     * @method DataType|$this shift(int $count = 1)
     * @method DataType|null firstOrFail($key = null, $operator = null, $value = null)
     * @method DataType|$this pop(int $count = 1)
     * @method DataType|null pull($key, $default = null)
     * @method DataType|null last(callable $callback = null, $default = null)
     * @method DataType|$this random($number = null)
     * @method DataType|null sole($key = null, $operator = null, $value = null)
     * @method DataType|null get($key, $default = null)
     * @method DataType|null first(callable $callback = null, $default = null)
     * @method DataType|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method DataType|null find($key, $default = null)
     * @method DataType[] all()
     */
    class _IH_DataType_C extends _BaseCollection {
        /**
         * @param int $size
         * @return DataType[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method DataType baseSole(array|string $columns = ['*'])
     * @method DataType create(array $attributes = [])
     * @method _IH_DataType_C|DataType[] cursor()
     * @method DataType|null|_IH_DataType_C|DataType[] find($id, array|string $columns = ['*'])
     * @method _IH_DataType_C|DataType[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method DataType|_IH_DataType_C|DataType[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method DataType|_IH_DataType_C|DataType[] findOrFail($id, array|string $columns = ['*'])
     * @method DataType|_IH_DataType_C|DataType[] findOrNew($id, array|string $columns = ['*'])
     * @method DataType first(array|string $columns = ['*'])
     * @method DataType firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method DataType firstOrCreate(array $attributes = [], array $values = [])
     * @method DataType firstOrFail(array|string $columns = ['*'])
     * @method DataType firstOrNew(array $attributes = [], array $values = [])
     * @method DataType firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method DataType forceCreate(array $attributes)
     * @method _IH_DataType_C|DataType[] fromQuery(string $query, array $bindings = [])
     * @method _IH_DataType_C|DataType[] get(array|string $columns = ['*'])
     * @method DataType getModel()
     * @method DataType[] getModels(array|string $columns = ['*'])
     * @method _IH_DataType_C|DataType[] hydrate(array $items)
     * @method DataType make(array $attributes = [])
     * @method DataType newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|DataType[]|_IH_DataType_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|DataType[]|_IH_DataType_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method DataType sole(array|string $columns = ['*'])
     * @method DataType updateOrCreate(array $attributes, array $values = [])
     * @method _IH_DataType_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_DataType_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_DataType_QB extends _BaseBuilder {}

    /**
     * @method MenuItem|null getOrPut($key, $value)
     * @method MenuItem|$this shift(int $count = 1)
     * @method MenuItem|null firstOrFail($key = null, $operator = null, $value = null)
     * @method MenuItem|$this pop(int $count = 1)
     * @method MenuItem|null pull($key, $default = null)
     * @method MenuItem|null last(callable $callback = null, $default = null)
     * @method MenuItem|$this random($number = null)
     * @method MenuItem|null sole($key = null, $operator = null, $value = null)
     * @method MenuItem|null get($key, $default = null)
     * @method MenuItem|null first(callable $callback = null, $default = null)
     * @method MenuItem|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method MenuItem|null find($key, $default = null)
     * @method MenuItem[] all()
     */
    class _IH_MenuItem_C extends _BaseCollection {
        /**
         * @param int $size
         * @return MenuItem[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method MenuItem baseSole(array|string $columns = ['*'])
     * @method MenuItem create(array $attributes = [])
     * @method _IH_MenuItem_C|MenuItem[] cursor()
     * @method MenuItem|null|_IH_MenuItem_C|MenuItem[] find($id, array|string $columns = ['*'])
     * @method _IH_MenuItem_C|MenuItem[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method MenuItem|_IH_MenuItem_C|MenuItem[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method MenuItem|_IH_MenuItem_C|MenuItem[] findOrFail($id, array|string $columns = ['*'])
     * @method MenuItem|_IH_MenuItem_C|MenuItem[] findOrNew($id, array|string $columns = ['*'])
     * @method MenuItem first(array|string $columns = ['*'])
     * @method MenuItem firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method MenuItem firstOrCreate(array $attributes = [], array $values = [])
     * @method MenuItem firstOrFail(array|string $columns = ['*'])
     * @method MenuItem firstOrNew(array $attributes = [], array $values = [])
     * @method MenuItem firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method MenuItem forceCreate(array $attributes)
     * @method _IH_MenuItem_C|MenuItem[] fromQuery(string $query, array $bindings = [])
     * @method _IH_MenuItem_C|MenuItem[] get(array|string $columns = ['*'])
     * @method MenuItem getModel()
     * @method MenuItem[] getModels(array|string $columns = ['*'])
     * @method _IH_MenuItem_C|MenuItem[] hydrate(array $items)
     * @method MenuItem make(array $attributes = [])
     * @method MenuItem newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|MenuItem[]|_IH_MenuItem_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|MenuItem[]|_IH_MenuItem_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method MenuItem sole(array|string $columns = ['*'])
     * @method MenuItem updateOrCreate(array $attributes, array $values = [])
     * @method _IH_MenuItem_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_MenuItem_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_MenuItem_QB extends _BaseBuilder {}

    /**
     * @method Menu|null getOrPut($key, $value)
     * @method Menu|$this shift(int $count = 1)
     * @method Menu|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Menu|$this pop(int $count = 1)
     * @method Menu|null pull($key, $default = null)
     * @method Menu|null last(callable $callback = null, $default = null)
     * @method Menu|$this random($number = null)
     * @method Menu|null sole($key = null, $operator = null, $value = null)
     * @method Menu|null get($key, $default = null)
     * @method Menu|null first(callable $callback = null, $default = null)
     * @method Menu|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Menu|null find($key, $default = null)
     * @method Menu[] all()
     */
    class _IH_Menu_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Menu[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Menu baseSole(array|string $columns = ['*'])
     * @method Menu create(array $attributes = [])
     * @method _IH_Menu_C|Menu[] cursor()
     * @method Menu|null|_IH_Menu_C|Menu[] find($id, array|string $columns = ['*'])
     * @method _IH_Menu_C|Menu[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Menu|_IH_Menu_C|Menu[] findOrFail($id, array|string $columns = ['*'])
     * @method Menu|_IH_Menu_C|Menu[] findOrNew($id, array|string $columns = ['*'])
     * @method Menu first(array|string $columns = ['*'])
     * @method Menu firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Menu firstOrCreate(array $attributes = [], array $values = [])
     * @method Menu firstOrFail(array|string $columns = ['*'])
     * @method Menu firstOrNew(array $attributes = [], array $values = [])
     * @method Menu firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Menu forceCreate(array $attributes)
     * @method _IH_Menu_C|Menu[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Menu_C|Menu[] get(array|string $columns = ['*'])
     * @method Menu getModel()
     * @method Menu[] getModels(array|string $columns = ['*'])
     * @method _IH_Menu_C|Menu[] hydrate(array $items)
     * @method Menu make(array $attributes = [])
     * @method Menu newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Menu[]|_IH_Menu_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Menu[]|_IH_Menu_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Menu sole(array|string $columns = ['*'])
     * @method Menu updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Menu_QB extends _BaseBuilder {}

    /**
     * @method Page|null getOrPut($key, $value)
     * @method Page|$this shift(int $count = 1)
     * @method Page|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Page|$this pop(int $count = 1)
     * @method Page|null pull($key, $default = null)
     * @method Page|null last(callable $callback = null, $default = null)
     * @method Page|$this random($number = null)
     * @method Page|null sole($key = null, $operator = null, $value = null)
     * @method Page|null get($key, $default = null)
     * @method Page|null first(callable $callback = null, $default = null)
     * @method Page|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Page|null find($key, $default = null)
     * @method Page[] all()
     */
    class _IH_Page_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Page[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Page baseSole(array|string $columns = ['*'])
     * @method Page create(array $attributes = [])
     * @method _IH_Page_C|Page[] cursor()
     * @method Page|null|_IH_Page_C|Page[] find($id, array|string $columns = ['*'])
     * @method _IH_Page_C|Page[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Page|_IH_Page_C|Page[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Page|_IH_Page_C|Page[] findOrFail($id, array|string $columns = ['*'])
     * @method Page|_IH_Page_C|Page[] findOrNew($id, array|string $columns = ['*'])
     * @method Page first(array|string $columns = ['*'])
     * @method Page firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Page firstOrCreate(array $attributes = [], array $values = [])
     * @method Page firstOrFail(array|string $columns = ['*'])
     * @method Page firstOrNew(array $attributes = [], array $values = [])
     * @method Page firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Page forceCreate(array $attributes)
     * @method _IH_Page_C|Page[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Page_C|Page[] get(array|string $columns = ['*'])
     * @method Page getModel()
     * @method Page[] getModels(array|string $columns = ['*'])
     * @method _IH_Page_C|Page[] hydrate(array $items)
     * @method Page make(array $attributes = [])
     * @method Page newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Page[]|_IH_Page_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Page[]|_IH_Page_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Page sole(array|string $columns = ['*'])
     * @method Page updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Page_QB active()
     * @method _IH_Page_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Page_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Page_QB extends _BaseBuilder {}

    /**
     * @method Permission|null getOrPut($key, $value)
     * @method Permission|$this shift(int $count = 1)
     * @method Permission|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Permission|$this pop(int $count = 1)
     * @method Permission|null pull($key, $default = null)
     * @method Permission|null last(callable $callback = null, $default = null)
     * @method Permission|$this random($number = null)
     * @method Permission|null sole($key = null, $operator = null, $value = null)
     * @method Permission|null get($key, $default = null)
     * @method Permission|null first(callable $callback = null, $default = null)
     * @method Permission|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Permission|null find($key, $default = null)
     * @method Permission[] all()
     */
    class _IH_Permission_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Permission[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Permission baseSole(array|string $columns = ['*'])
     * @method Permission create(array $attributes = [])
     * @method _IH_Permission_C|Permission[] cursor()
     * @method Permission|null|_IH_Permission_C|Permission[] find($id, array|string $columns = ['*'])
     * @method _IH_Permission_C|Permission[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Permission|_IH_Permission_C|Permission[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Permission|_IH_Permission_C|Permission[] findOrFail($id, array|string $columns = ['*'])
     * @method Permission|_IH_Permission_C|Permission[] findOrNew($id, array|string $columns = ['*'])
     * @method Permission first(array|string $columns = ['*'])
     * @method Permission firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Permission firstOrCreate(array $attributes = [], array $values = [])
     * @method Permission firstOrFail(array|string $columns = ['*'])
     * @method Permission firstOrNew(array $attributes = [], array $values = [])
     * @method Permission firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Permission forceCreate(array $attributes)
     * @method _IH_Permission_C|Permission[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Permission_C|Permission[] get(array|string $columns = ['*'])
     * @method Permission getModel()
     * @method Permission[] getModels(array|string $columns = ['*'])
     * @method _IH_Permission_C|Permission[] hydrate(array $items)
     * @method Permission make(array $attributes = [])
     * @method Permission newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Permission[]|_IH_Permission_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Permission[]|_IH_Permission_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Permission sole(array|string $columns = ['*'])
     * @method Permission updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Permission_QB extends _BaseBuilder {}

    /**
     * @method Post|null getOrPut($key, $value)
     * @method Post|$this shift(int $count = 1)
     * @method Post|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Post|$this pop(int $count = 1)
     * @method Post|null pull($key, $default = null)
     * @method Post|null last(callable $callback = null, $default = null)
     * @method Post|$this random($number = null)
     * @method Post|null sole($key = null, $operator = null, $value = null)
     * @method Post|null get($key, $default = null)
     * @method Post|null first(callable $callback = null, $default = null)
     * @method Post|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Post|null find($key, $default = null)
     * @method Post[] all()
     */
    class _IH_Post_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Post[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Post baseSole(array|string $columns = ['*'])
     * @method Post create(array $attributes = [])
     * @method _IH_Post_C|Post[] cursor()
     * @method Post|null|_IH_Post_C|Post[] find($id, array|string $columns = ['*'])
     * @method _IH_Post_C|Post[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Post|_IH_Post_C|Post[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Post|_IH_Post_C|Post[] findOrFail($id, array|string $columns = ['*'])
     * @method Post|_IH_Post_C|Post[] findOrNew($id, array|string $columns = ['*'])
     * @method Post first(array|string $columns = ['*'])
     * @method Post firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Post firstOrCreate(array $attributes = [], array $values = [])
     * @method Post firstOrFail(array|string $columns = ['*'])
     * @method Post firstOrNew(array $attributes = [], array $values = [])
     * @method Post firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Post forceCreate(array $attributes)
     * @method _IH_Post_C|Post[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Post_C|Post[] get(array|string $columns = ['*'])
     * @method Post getModel()
     * @method Post[] getModels(array|string $columns = ['*'])
     * @method _IH_Post_C|Post[] hydrate(array $items)
     * @method Post make(array $attributes = [])
     * @method Post newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Post[]|_IH_Post_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Post[]|_IH_Post_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Post sole(array|string $columns = ['*'])
     * @method Post updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Post_QB published()
     * @method _IH_Post_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Post_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Post_QB extends _BaseBuilder {}

    /**
     * @method Role|null getOrPut($key, $value)
     * @method Role|$this shift(int $count = 1)
     * @method Role|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Role|$this pop(int $count = 1)
     * @method Role|null pull($key, $default = null)
     * @method Role|null last(callable $callback = null, $default = null)
     * @method Role|$this random($number = null)
     * @method Role|null sole($key = null, $operator = null, $value = null)
     * @method Role|null get($key, $default = null)
     * @method Role|null first(callable $callback = null, $default = null)
     * @method Role|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Role|null find($key, $default = null)
     * @method Role[] all()
     */
    class _IH_Role_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Role[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Role baseSole(array|string $columns = ['*'])
     * @method Role create(array $attributes = [])
     * @method _IH_Role_C|Role[] cursor()
     * @method Role|null|_IH_Role_C|Role[] find($id, array|string $columns = ['*'])
     * @method _IH_Role_C|Role[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Role|_IH_Role_C|Role[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Role|_IH_Role_C|Role[] findOrFail($id, array|string $columns = ['*'])
     * @method Role|_IH_Role_C|Role[] findOrNew($id, array|string $columns = ['*'])
     * @method Role first(array|string $columns = ['*'])
     * @method Role firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Role firstOrCreate(array $attributes = [], array $values = [])
     * @method Role firstOrFail(array|string $columns = ['*'])
     * @method Role firstOrNew(array $attributes = [], array $values = [])
     * @method Role firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Role forceCreate(array $attributes)
     * @method _IH_Role_C|Role[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Role_C|Role[] get(array|string $columns = ['*'])
     * @method Role getModel()
     * @method Role[] getModels(array|string $columns = ['*'])
     * @method _IH_Role_C|Role[] hydrate(array $items)
     * @method Role make(array $attributes = [])
     * @method Role newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Role[]|_IH_Role_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Role[]|_IH_Role_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Role sole(array|string $columns = ['*'])
     * @method Role updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Role_QB show()
     */
    class _IH_Role_QB extends _BaseBuilder {}

    /**
     * @method Setting|null getOrPut($key, $value)
     * @method Setting|$this shift(int $count = 1)
     * @method Setting|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Setting|$this pop(int $count = 1)
     * @method Setting|null pull($key, $default = null)
     * @method Setting|null last(callable $callback = null, $default = null)
     * @method Setting|$this random($number = null)
     * @method Setting|null sole($key = null, $operator = null, $value = null)
     * @method Setting|null get($key, $default = null)
     * @method Setting|null first(callable $callback = null, $default = null)
     * @method Setting|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Setting|null find($key, $default = null)
     * @method Setting[] all()
     */
    class _IH_Setting_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Setting[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Setting baseSole(array|string $columns = ['*'])
     * @method Setting create(array $attributes = [])
     * @method _IH_Setting_C|Setting[] cursor()
     * @method Setting|null|_IH_Setting_C|Setting[] find($id, array|string $columns = ['*'])
     * @method _IH_Setting_C|Setting[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Setting|_IH_Setting_C|Setting[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Setting|_IH_Setting_C|Setting[] findOrFail($id, array|string $columns = ['*'])
     * @method Setting|_IH_Setting_C|Setting[] findOrNew($id, array|string $columns = ['*'])
     * @method Setting first(array|string $columns = ['*'])
     * @method Setting firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Setting firstOrCreate(array $attributes = [], array $values = [])
     * @method Setting firstOrFail(array|string $columns = ['*'])
     * @method Setting firstOrNew(array $attributes = [], array $values = [])
     * @method Setting firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Setting forceCreate(array $attributes)
     * @method _IH_Setting_C|Setting[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Setting_C|Setting[] get(array|string $columns = ['*'])
     * @method Setting getModel()
     * @method Setting[] getModels(array|string $columns = ['*'])
     * @method _IH_Setting_C|Setting[] hydrate(array $items)
     * @method Setting make(array $attributes = [])
     * @method Setting newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Setting[]|_IH_Setting_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Setting[]|_IH_Setting_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Setting sole(array|string $columns = ['*'])
     * @method Setting updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Setting_QB extends _BaseBuilder {}

    /**
     * @method Translation|null getOrPut($key, $value)
     * @method Translation|$this shift(int $count = 1)
     * @method Translation|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Translation|$this pop(int $count = 1)
     * @method Translation|null pull($key, $default = null)
     * @method Translation|null last(callable $callback = null, $default = null)
     * @method Translation|$this random($number = null)
     * @method Translation|null sole($key = null, $operator = null, $value = null)
     * @method Translation|null get($key, $default = null)
     * @method Translation|null first(callable $callback = null, $default = null)
     * @method Translation|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Translation|null find($key, $default = null)
     * @method Translation[] all()
     */
    class _IH_Translation_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Translation[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Translation baseSole(array|string $columns = ['*'])
     * @method Translation create(array $attributes = [])
     * @method _IH_Translation_C|Translation[] cursor()
     * @method Translation|null|_IH_Translation_C|Translation[] find($id, array|string $columns = ['*'])
     * @method _IH_Translation_C|Translation[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Translation|_IH_Translation_C|Translation[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Translation|_IH_Translation_C|Translation[] findOrFail($id, array|string $columns = ['*'])
     * @method Translation|_IH_Translation_C|Translation[] findOrNew($id, array|string $columns = ['*'])
     * @method Translation first(array|string $columns = ['*'])
     * @method Translation firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Translation firstOrCreate(array $attributes = [], array $values = [])
     * @method Translation firstOrFail(array|string $columns = ['*'])
     * @method Translation firstOrNew(array $attributes = [], array $values = [])
     * @method Translation firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Translation forceCreate(array $attributes)
     * @method _IH_Translation_C|Translation[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Translation_C|Translation[] get(array|string $columns = ['*'])
     * @method Translation getModel()
     * @method Translation[] getModels(array|string $columns = ['*'])
     * @method _IH_Translation_C|Translation[] hydrate(array $items)
     * @method Translation make(array $attributes = [])
     * @method Translation newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Translation[]|_IH_Translation_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Translation[]|_IH_Translation_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Translation sole(array|string $columns = ['*'])
     * @method Translation updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Translation_QB extends _BaseBuilder {}

    /**
     * @method User|null getOrPut($key, $value)
     * @method User|$this shift(int $count = 1)
     * @method User|null firstOrFail($key = null, $operator = null, $value = null)
     * @method User|$this pop(int $count = 1)
     * @method User|null pull($key, $default = null)
     * @method User|null last(callable $callback = null, $default = null)
     * @method User|$this random($number = null)
     * @method User|null sole($key = null, $operator = null, $value = null)
     * @method User|null get($key, $default = null)
     * @method User|null first(callable $callback = null, $default = null)
     * @method User|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method User|null find($key, $default = null)
     * @method User[] all()
     */
    class _IH_User_C extends _BaseCollection {
        /**
         * @param int $size
         * @return User[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method _IH_User_QB whereId($value)
     * @method _IH_User_QB whereName($value)
     * @method _IH_User_QB whereEmail($value)
     * @method _IH_User_QB whereEmailVerifiedAt($value)
     * @method _IH_User_QB wherePassword($value)
     * @method _IH_User_QB whereRememberToken($value)
     * @method _IH_User_QB whereCreatedAt($value)
     * @method _IH_User_QB whereUpdatedAt($value)
     * @method User baseSole(array|string $columns = ['*'])
     * @method User create(array $attributes = [])
     * @method _IH_User_C|User[] cursor()
     * @method User|null|_IH_User_C|User[] find($id, array|string $columns = ['*'])
     * @method _IH_User_C|User[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method User|_IH_User_C|User[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method User|_IH_User_C|User[] findOrFail($id, array|string $columns = ['*'])
     * @method User|_IH_User_C|User[] findOrNew($id, array|string $columns = ['*'])
     * @method User first(array|string $columns = ['*'])
     * @method User firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method User firstOrCreate(array $attributes = [], array $values = [])
     * @method User firstOrFail(array|string $columns = ['*'])
     * @method User firstOrNew(array $attributes = [], array $values = [])
     * @method User firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method User forceCreate(array $attributes)
     * @method _IH_User_C|User[] fromQuery(string $query, array $bindings = [])
     * @method _IH_User_C|User[] get(array|string $columns = ['*'])
     * @method User getModel()
     * @method User[] getModels(array|string $columns = ['*'])
     * @method _IH_User_C|User[] hydrate(array $items)
     * @method User make(array $attributes = [])
     * @method User newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|User[]|_IH_User_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|User[]|_IH_User_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method User sole(array|string $columns = ['*'])
     * @method User updateOrCreate(array $attributes, array $values = [])
     * @method _IH_User_QB withTrashed()
     * @method _IH_User_QB onlyTrashed()
     * @method _IH_User_QB withoutTrashed()
     * @method _IH_User_QB restore()
     * @method _IH_User_QB partners()
     * @method _IH_User_QB show()
     */
    class _IH_User_QB extends _BaseBuilder {}
}
