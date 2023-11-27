<?php //006654ad16ac9fad41341764798ce5aa
/** @noinspection all */

namespace LaravelIdea\Helper\App\Models {

    use App\Models\Authority;
    use App\Models\Brand;
    use App\Models\Card;
    use App\Models\CardAdvantage;
    use App\Models\CardsCardAdvantage;
    use App\Models\City;
    use App\Models\Country;
    use App\Models\Message;
    use App\Models\Offer;
    use App\Models\SpecialFeature;
    use App\Models\Subscribe;
    use App\Models\User;
    use Illuminate\Contracts\Support\Arrayable;
    use Illuminate\Database\Query\Expression;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Pagination\Paginator;
    use LaravelIdea\Helper\_BaseBuilder;
    use LaravelIdea\Helper\_BaseCollection;

    /**
     * @method Authority|null getOrPut($key, $value)
     * @method Authority|$this shift(int $count = 1)
     * @method Authority|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Authority|$this pop(int $count = 1)
     * @method Authority|null pull($key, $default = null)
     * @method Authority|null last(callable $callback = null, $default = null)
     * @method Authority|$this random($number = null)
     * @method Authority|null sole($key = null, $operator = null, $value = null)
     * @method Authority|null get($key, $default = null)
     * @method Authority|null first(callable $callback = null, $default = null)
     * @method Authority|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Authority|null find($key, $default = null)
     * @method Authority[] all()
     */
    class _IH_Authority_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Authority[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Authority baseSole(array|string $columns = ['*'])
     * @method Authority create(array $attributes = [])
     * @method _IH_Authority_C|Authority[] cursor()
     * @method Authority|null|_IH_Authority_C|Authority[] find($id, array|string $columns = ['*'])
     * @method _IH_Authority_C|Authority[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Authority|_IH_Authority_C|Authority[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Authority|_IH_Authority_C|Authority[] findOrFail($id, array|string $columns = ['*'])
     * @method Authority|_IH_Authority_C|Authority[] findOrNew($id, array|string $columns = ['*'])
     * @method Authority first(array|string $columns = ['*'])
     * @method Authority firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Authority firstOrCreate(array $attributes = [], array $values = [])
     * @method Authority firstOrFail(array|string $columns = ['*'])
     * @method Authority firstOrNew(array $attributes = [], array $values = [])
     * @method Authority firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Authority forceCreate(array $attributes)
     * @method _IH_Authority_C|Authority[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Authority_C|Authority[] get(array|string $columns = ['*'])
     * @method Authority getModel()
     * @method Authority[] getModels(array|string $columns = ['*'])
     * @method _IH_Authority_C|Authority[] hydrate(array $items)
     * @method Authority make(array $attributes = [])
     * @method Authority newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Authority[]|_IH_Authority_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Authority[]|_IH_Authority_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Authority sole(array|string $columns = ['*'])
     * @method Authority updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Authority_QB withTrashed()
     * @method _IH_Authority_QB onlyTrashed()
     * @method _IH_Authority_QB withoutTrashed()
     * @method _IH_Authority_QB restore()
     * @method _IH_Authority_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Authority_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Authority_QB extends _BaseBuilder {}

    /**
     * @method Brand|null getOrPut($key, $value)
     * @method Brand|$this shift(int $count = 1)
     * @method Brand|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Brand|$this pop(int $count = 1)
     * @method Brand|null pull($key, $default = null)
     * @method Brand|null last(callable $callback = null, $default = null)
     * @method Brand|$this random($number = null)
     * @method Brand|null sole($key = null, $operator = null, $value = null)
     * @method Brand|null get($key, $default = null)
     * @method Brand|null first(callable $callback = null, $default = null)
     * @method Brand|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Brand|null find($key, $default = null)
     * @method Brand[] all()
     */
    class _IH_Brand_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Brand[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Brand baseSole(array|string $columns = ['*'])
     * @method Brand create(array $attributes = [])
     * @method _IH_Brand_C|Brand[] cursor()
     * @method Brand|null|_IH_Brand_C|Brand[] find($id, array|string $columns = ['*'])
     * @method _IH_Brand_C|Brand[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Brand|_IH_Brand_C|Brand[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Brand|_IH_Brand_C|Brand[] findOrFail($id, array|string $columns = ['*'])
     * @method Brand|_IH_Brand_C|Brand[] findOrNew($id, array|string $columns = ['*'])
     * @method Brand first(array|string $columns = ['*'])
     * @method Brand firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Brand firstOrCreate(array $attributes = [], array $values = [])
     * @method Brand firstOrFail(array|string $columns = ['*'])
     * @method Brand firstOrNew(array $attributes = [], array $values = [])
     * @method Brand firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Brand forceCreate(array $attributes)
     * @method _IH_Brand_C|Brand[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Brand_C|Brand[] get(array|string $columns = ['*'])
     * @method Brand getModel()
     * @method Brand[] getModels(array|string $columns = ['*'])
     * @method _IH_Brand_C|Brand[] hydrate(array $items)
     * @method Brand make(array $attributes = [])
     * @method Brand newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Brand[]|_IH_Brand_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Brand[]|_IH_Brand_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Brand sole(array|string $columns = ['*'])
     * @method Brand updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Brand_QB withTrashed()
     * @method _IH_Brand_QB onlyTrashed()
     * @method _IH_Brand_QB withoutTrashed()
     * @method _IH_Brand_QB restore()
     * @method _IH_Brand_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Brand_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Brand_QB extends _BaseBuilder {}

    /**
     * @method CardAdvantage|null getOrPut($key, $value)
     * @method CardAdvantage|$this shift(int $count = 1)
     * @method CardAdvantage|null firstOrFail($key = null, $operator = null, $value = null)
     * @method CardAdvantage|$this pop(int $count = 1)
     * @method CardAdvantage|null pull($key, $default = null)
     * @method CardAdvantage|null last(callable $callback = null, $default = null)
     * @method CardAdvantage|$this random($number = null)
     * @method CardAdvantage|null sole($key = null, $operator = null, $value = null)
     * @method CardAdvantage|null get($key, $default = null)
     * @method CardAdvantage|null first(callable $callback = null, $default = null)
     * @method CardAdvantage|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method CardAdvantage|null find($key, $default = null)
     * @method CardAdvantage[] all()
     */
    class _IH_CardAdvantage_C extends _BaseCollection {
        /**
         * @param int $size
         * @return CardAdvantage[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method CardAdvantage baseSole(array|string $columns = ['*'])
     * @method CardAdvantage create(array $attributes = [])
     * @method _IH_CardAdvantage_C|CardAdvantage[] cursor()
     * @method CardAdvantage|null|_IH_CardAdvantage_C|CardAdvantage[] find($id, array|string $columns = ['*'])
     * @method _IH_CardAdvantage_C|CardAdvantage[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method CardAdvantage|_IH_CardAdvantage_C|CardAdvantage[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method CardAdvantage|_IH_CardAdvantage_C|CardAdvantage[] findOrFail($id, array|string $columns = ['*'])
     * @method CardAdvantage|_IH_CardAdvantage_C|CardAdvantage[] findOrNew($id, array|string $columns = ['*'])
     * @method CardAdvantage first(array|string $columns = ['*'])
     * @method CardAdvantage firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method CardAdvantage firstOrCreate(array $attributes = [], array $values = [])
     * @method CardAdvantage firstOrFail(array|string $columns = ['*'])
     * @method CardAdvantage firstOrNew(array $attributes = [], array $values = [])
     * @method CardAdvantage firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method CardAdvantage forceCreate(array $attributes)
     * @method _IH_CardAdvantage_C|CardAdvantage[] fromQuery(string $query, array $bindings = [])
     * @method _IH_CardAdvantage_C|CardAdvantage[] get(array|string $columns = ['*'])
     * @method CardAdvantage getModel()
     * @method CardAdvantage[] getModels(array|string $columns = ['*'])
     * @method _IH_CardAdvantage_C|CardAdvantage[] hydrate(array $items)
     * @method CardAdvantage make(array $attributes = [])
     * @method CardAdvantage newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|CardAdvantage[]|_IH_CardAdvantage_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|CardAdvantage[]|_IH_CardAdvantage_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method CardAdvantage sole(array|string $columns = ['*'])
     * @method CardAdvantage updateOrCreate(array $attributes, array $values = [])
     * @method _IH_CardAdvantage_QB withTrashed()
     * @method _IH_CardAdvantage_QB onlyTrashed()
     * @method _IH_CardAdvantage_QB withoutTrashed()
     * @method _IH_CardAdvantage_QB restore()
     * @method _IH_CardAdvantage_QB active()
     * @method _IH_CardAdvantage_QB home()
     * @method _IH_CardAdvantage_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_CardAdvantage_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_CardAdvantage_QB extends _BaseBuilder {}

    /**
     * @method Card|null getOrPut($key, $value)
     * @method Card|$this shift(int $count = 1)
     * @method Card|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Card|$this pop(int $count = 1)
     * @method Card|null pull($key, $default = null)
     * @method Card|null last(callable $callback = null, $default = null)
     * @method Card|$this random($number = null)
     * @method Card|null sole($key = null, $operator = null, $value = null)
     * @method Card|null get($key, $default = null)
     * @method Card|null first(callable $callback = null, $default = null)
     * @method Card|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Card|null find($key, $default = null)
     * @method Card[] all()
     */
    class _IH_Card_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Card[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Card baseSole(array|string $columns = ['*'])
     * @method Card create(array $attributes = [])
     * @method _IH_Card_C|Card[] cursor()
     * @method Card|null|_IH_Card_C|Card[] find($id, array|string $columns = ['*'])
     * @method _IH_Card_C|Card[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Card|_IH_Card_C|Card[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Card|_IH_Card_C|Card[] findOrFail($id, array|string $columns = ['*'])
     * @method Card|_IH_Card_C|Card[] findOrNew($id, array|string $columns = ['*'])
     * @method Card first(array|string $columns = ['*'])
     * @method Card firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Card firstOrCreate(array $attributes = [], array $values = [])
     * @method Card firstOrFail(array|string $columns = ['*'])
     * @method Card firstOrNew(array $attributes = [], array $values = [])
     * @method Card firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Card forceCreate(array $attributes)
     * @method _IH_Card_C|Card[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Card_C|Card[] get(array|string $columns = ['*'])
     * @method Card getModel()
     * @method Card[] getModels(array|string $columns = ['*'])
     * @method _IH_Card_C|Card[] hydrate(array $items)
     * @method Card make(array $attributes = [])
     * @method Card newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Card[]|_IH_Card_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Card[]|_IH_Card_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Card sole(array|string $columns = ['*'])
     * @method Card updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Card_QB withTrashed()
     * @method _IH_Card_QB onlyTrashed()
     * @method _IH_Card_QB withoutTrashed()
     * @method _IH_Card_QB restore()
     * @method _IH_Card_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Card_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Card_QB extends _BaseBuilder {}

    /**
     * @method CardsCardAdvantage|null getOrPut($key, $value)
     * @method CardsCardAdvantage|$this shift(int $count = 1)
     * @method CardsCardAdvantage|null firstOrFail($key = null, $operator = null, $value = null)
     * @method CardsCardAdvantage|$this pop(int $count = 1)
     * @method CardsCardAdvantage|null pull($key, $default = null)
     * @method CardsCardAdvantage|null last(callable $callback = null, $default = null)
     * @method CardsCardAdvantage|$this random($number = null)
     * @method CardsCardAdvantage|null sole($key = null, $operator = null, $value = null)
     * @method CardsCardAdvantage|null get($key, $default = null)
     * @method CardsCardAdvantage|null first(callable $callback = null, $default = null)
     * @method CardsCardAdvantage|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method CardsCardAdvantage|null find($key, $default = null)
     * @method CardsCardAdvantage[] all()
     */
    class _IH_CardsCardAdvantage_C extends _BaseCollection {
        /**
         * @param int $size
         * @return CardsCardAdvantage[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method CardsCardAdvantage baseSole(array|string $columns = ['*'])
     * @method CardsCardAdvantage create(array $attributes = [])
     * @method _IH_CardsCardAdvantage_C|CardsCardAdvantage[] cursor()
     * @method CardsCardAdvantage|null|_IH_CardsCardAdvantage_C|CardsCardAdvantage[] find($id, array|string $columns = ['*'])
     * @method _IH_CardsCardAdvantage_C|CardsCardAdvantage[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method CardsCardAdvantage|_IH_CardsCardAdvantage_C|CardsCardAdvantage[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method CardsCardAdvantage|_IH_CardsCardAdvantage_C|CardsCardAdvantage[] findOrFail($id, array|string $columns = ['*'])
     * @method CardsCardAdvantage|_IH_CardsCardAdvantage_C|CardsCardAdvantage[] findOrNew($id, array|string $columns = ['*'])
     * @method CardsCardAdvantage first(array|string $columns = ['*'])
     * @method CardsCardAdvantage firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method CardsCardAdvantage firstOrCreate(array $attributes = [], array $values = [])
     * @method CardsCardAdvantage firstOrFail(array|string $columns = ['*'])
     * @method CardsCardAdvantage firstOrNew(array $attributes = [], array $values = [])
     * @method CardsCardAdvantage firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method CardsCardAdvantage forceCreate(array $attributes)
     * @method _IH_CardsCardAdvantage_C|CardsCardAdvantage[] fromQuery(string $query, array $bindings = [])
     * @method _IH_CardsCardAdvantage_C|CardsCardAdvantage[] get(array|string $columns = ['*'])
     * @method CardsCardAdvantage getModel()
     * @method CardsCardAdvantage[] getModels(array|string $columns = ['*'])
     * @method _IH_CardsCardAdvantage_C|CardsCardAdvantage[] hydrate(array $items)
     * @method CardsCardAdvantage make(array $attributes = [])
     * @method CardsCardAdvantage newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|CardsCardAdvantage[]|_IH_CardsCardAdvantage_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|CardsCardAdvantage[]|_IH_CardsCardAdvantage_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method CardsCardAdvantage sole(array|string $columns = ['*'])
     * @method CardsCardAdvantage updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_CardsCardAdvantage_QB extends _BaseBuilder {}

    /**
     * @method City|null getOrPut($key, $value)
     * @method City|$this shift(int $count = 1)
     * @method City|null firstOrFail($key = null, $operator = null, $value = null)
     * @method City|$this pop(int $count = 1)
     * @method City|null pull($key, $default = null)
     * @method City|null last(callable $callback = null, $default = null)
     * @method City|$this random($number = null)
     * @method City|null sole($key = null, $operator = null, $value = null)
     * @method City|null get($key, $default = null)
     * @method City|null first(callable $callback = null, $default = null)
     * @method City|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method City|null find($key, $default = null)
     * @method City[] all()
     */
    class _IH_City_C extends _BaseCollection {
        /**
         * @param int $size
         * @return City[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method City baseSole(array|string $columns = ['*'])
     * @method City create(array $attributes = [])
     * @method _IH_City_C|City[] cursor()
     * @method City|null|_IH_City_C|City[] find($id, array|string $columns = ['*'])
     * @method _IH_City_C|City[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method City|_IH_City_C|City[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method City|_IH_City_C|City[] findOrFail($id, array|string $columns = ['*'])
     * @method City|_IH_City_C|City[] findOrNew($id, array|string $columns = ['*'])
     * @method City first(array|string $columns = ['*'])
     * @method City firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method City firstOrCreate(array $attributes = [], array $values = [])
     * @method City firstOrFail(array|string $columns = ['*'])
     * @method City firstOrNew(array $attributes = [], array $values = [])
     * @method City firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method City forceCreate(array $attributes)
     * @method _IH_City_C|City[] fromQuery(string $query, array $bindings = [])
     * @method _IH_City_C|City[] get(array|string $columns = ['*'])
     * @method City getModel()
     * @method City[] getModels(array|string $columns = ['*'])
     * @method _IH_City_C|City[] hydrate(array $items)
     * @method City make(array $attributes = [])
     * @method City newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|City[]|_IH_City_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|City[]|_IH_City_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method City sole(array|string $columns = ['*'])
     * @method City updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_City_QB extends _BaseBuilder {}

    /**
     * @method Country|null getOrPut($key, $value)
     * @method Country|$this shift(int $count = 1)
     * @method Country|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Country|$this pop(int $count = 1)
     * @method Country|null pull($key, $default = null)
     * @method Country|null last(callable $callback = null, $default = null)
     * @method Country|$this random($number = null)
     * @method Country|null sole($key = null, $operator = null, $value = null)
     * @method Country|null get($key, $default = null)
     * @method Country|null first(callable $callback = null, $default = null)
     * @method Country|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Country|null find($key, $default = null)
     * @method Country[] all()
     */
    class _IH_Country_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Country[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Country baseSole(array|string $columns = ['*'])
     * @method Country create(array $attributes = [])
     * @method _IH_Country_C|Country[] cursor()
     * @method Country|null|_IH_Country_C|Country[] find($id, array|string $columns = ['*'])
     * @method _IH_Country_C|Country[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Country|_IH_Country_C|Country[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Country|_IH_Country_C|Country[] findOrFail($id, array|string $columns = ['*'])
     * @method Country|_IH_Country_C|Country[] findOrNew($id, array|string $columns = ['*'])
     * @method Country first(array|string $columns = ['*'])
     * @method Country firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Country firstOrCreate(array $attributes = [], array $values = [])
     * @method Country firstOrFail(array|string $columns = ['*'])
     * @method Country firstOrNew(array $attributes = [], array $values = [])
     * @method Country firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Country forceCreate(array $attributes)
     * @method _IH_Country_C|Country[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Country_C|Country[] get(array|string $columns = ['*'])
     * @method Country getModel()
     * @method Country[] getModels(array|string $columns = ['*'])
     * @method _IH_Country_C|Country[] hydrate(array $items)
     * @method Country make(array $attributes = [])
     * @method Country newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Country[]|_IH_Country_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Country[]|_IH_Country_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Country sole(array|string $columns = ['*'])
     * @method Country updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Country_QB extends _BaseBuilder {}

    /**
     * @method Message|null getOrPut($key, $value)
     * @method Message|$this shift(int $count = 1)
     * @method Message|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Message|$this pop(int $count = 1)
     * @method Message|null pull($key, $default = null)
     * @method Message|null last(callable $callback = null, $default = null)
     * @method Message|$this random($number = null)
     * @method Message|null sole($key = null, $operator = null, $value = null)
     * @method Message|null get($key, $default = null)
     * @method Message|null first(callable $callback = null, $default = null)
     * @method Message|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Message|null find($key, $default = null)
     * @method Message[] all()
     */
    class _IH_Message_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Message[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Message baseSole(array|string $columns = ['*'])
     * @method Message create(array $attributes = [])
     * @method _IH_Message_C|Message[] cursor()
     * @method Message|null|_IH_Message_C|Message[] find($id, array|string $columns = ['*'])
     * @method _IH_Message_C|Message[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Message|_IH_Message_C|Message[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Message|_IH_Message_C|Message[] findOrFail($id, array|string $columns = ['*'])
     * @method Message|_IH_Message_C|Message[] findOrNew($id, array|string $columns = ['*'])
     * @method Message first(array|string $columns = ['*'])
     * @method Message firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Message firstOrCreate(array $attributes = [], array $values = [])
     * @method Message firstOrFail(array|string $columns = ['*'])
     * @method Message firstOrNew(array $attributes = [], array $values = [])
     * @method Message firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Message forceCreate(array $attributes)
     * @method _IH_Message_C|Message[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Message_C|Message[] get(array|string $columns = ['*'])
     * @method Message getModel()
     * @method Message[] getModels(array|string $columns = ['*'])
     * @method _IH_Message_C|Message[] hydrate(array $items)
     * @method Message make(array $attributes = [])
     * @method Message newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Message[]|_IH_Message_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Message[]|_IH_Message_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Message sole(array|string $columns = ['*'])
     * @method Message updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Message_QB extends _BaseBuilder {}

    /**
     * @method Offer|null getOrPut($key, $value)
     * @method Offer|$this shift(int $count = 1)
     * @method Offer|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Offer|$this pop(int $count = 1)
     * @method Offer|null pull($key, $default = null)
     * @method Offer|null last(callable $callback = null, $default = null)
     * @method Offer|$this random($number = null)
     * @method Offer|null sole($key = null, $operator = null, $value = null)
     * @method Offer|null get($key, $default = null)
     * @method Offer|null first(callable $callback = null, $default = null)
     * @method Offer|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Offer|null find($key, $default = null)
     * @method Offer[] all()
     */
    class _IH_Offer_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Offer[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Offer baseSole(array|string $columns = ['*'])
     * @method Offer create(array $attributes = [])
     * @method _IH_Offer_C|Offer[] cursor()
     * @method Offer|null|_IH_Offer_C|Offer[] find($id, array|string $columns = ['*'])
     * @method _IH_Offer_C|Offer[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Offer|_IH_Offer_C|Offer[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Offer|_IH_Offer_C|Offer[] findOrFail($id, array|string $columns = ['*'])
     * @method Offer|_IH_Offer_C|Offer[] findOrNew($id, array|string $columns = ['*'])
     * @method Offer first(array|string $columns = ['*'])
     * @method Offer firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Offer firstOrCreate(array $attributes = [], array $values = [])
     * @method Offer firstOrFail(array|string $columns = ['*'])
     * @method Offer firstOrNew(array $attributes = [], array $values = [])
     * @method Offer firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Offer forceCreate(array $attributes)
     * @method _IH_Offer_C|Offer[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Offer_C|Offer[] get(array|string $columns = ['*'])
     * @method Offer getModel()
     * @method Offer[] getModels(array|string $columns = ['*'])
     * @method _IH_Offer_C|Offer[] hydrate(array $items)
     * @method Offer make(array $attributes = [])
     * @method Offer newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Offer[]|_IH_Offer_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Offer[]|_IH_Offer_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Offer sole(array|string $columns = ['*'])
     * @method Offer updateOrCreate(array $attributes, array $values = [])
     * @method _IH_Offer_QB withTrashed()
     * @method _IH_Offer_QB onlyTrashed()
     * @method _IH_Offer_QB withoutTrashed()
     * @method _IH_Offer_QB restore()
     * @method _IH_Offer_QB active()
     * @method _IH_Offer_QB myOffers()
     * @method _IH_Offer_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_Offer_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_Offer_QB extends _BaseBuilder {}

    /**
     * @method SpecialFeature|null getOrPut($key, $value)
     * @method SpecialFeature|$this shift(int $count = 1)
     * @method SpecialFeature|null firstOrFail($key = null, $operator = null, $value = null)
     * @method SpecialFeature|$this pop(int $count = 1)
     * @method SpecialFeature|null pull($key, $default = null)
     * @method SpecialFeature|null last(callable $callback = null, $default = null)
     * @method SpecialFeature|$this random($number = null)
     * @method SpecialFeature|null sole($key = null, $operator = null, $value = null)
     * @method SpecialFeature|null get($key, $default = null)
     * @method SpecialFeature|null first(callable $callback = null, $default = null)
     * @method SpecialFeature|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method SpecialFeature|null find($key, $default = null)
     * @method SpecialFeature[] all()
     */
    class _IH_SpecialFeature_C extends _BaseCollection {
        /**
         * @param int $size
         * @return SpecialFeature[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method SpecialFeature baseSole(array|string $columns = ['*'])
     * @method SpecialFeature create(array $attributes = [])
     * @method _IH_SpecialFeature_C|SpecialFeature[] cursor()
     * @method SpecialFeature|null|_IH_SpecialFeature_C|SpecialFeature[] find($id, array|string $columns = ['*'])
     * @method _IH_SpecialFeature_C|SpecialFeature[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method SpecialFeature|_IH_SpecialFeature_C|SpecialFeature[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method SpecialFeature|_IH_SpecialFeature_C|SpecialFeature[] findOrFail($id, array|string $columns = ['*'])
     * @method SpecialFeature|_IH_SpecialFeature_C|SpecialFeature[] findOrNew($id, array|string $columns = ['*'])
     * @method SpecialFeature first(array|string $columns = ['*'])
     * @method SpecialFeature firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method SpecialFeature firstOrCreate(array $attributes = [], array $values = [])
     * @method SpecialFeature firstOrFail(array|string $columns = ['*'])
     * @method SpecialFeature firstOrNew(array $attributes = [], array $values = [])
     * @method SpecialFeature firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method SpecialFeature forceCreate(array $attributes)
     * @method _IH_SpecialFeature_C|SpecialFeature[] fromQuery(string $query, array $bindings = [])
     * @method _IH_SpecialFeature_C|SpecialFeature[] get(array|string $columns = ['*'])
     * @method SpecialFeature getModel()
     * @method SpecialFeature[] getModels(array|string $columns = ['*'])
     * @method _IH_SpecialFeature_C|SpecialFeature[] hydrate(array $items)
     * @method SpecialFeature make(array $attributes = [])
     * @method SpecialFeature newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|SpecialFeature[]|_IH_SpecialFeature_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|SpecialFeature[]|_IH_SpecialFeature_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method SpecialFeature sole(array|string $columns = ['*'])
     * @method SpecialFeature updateOrCreate(array $attributes, array $values = [])
     * @method _IH_SpecialFeature_QB withTranslation(null|string $locale = null, bool|string $fallback = true)
     * @method _IH_SpecialFeature_QB withTranslations(array|null|string $locales = null, bool|string $fallback = true)
     */
    class _IH_SpecialFeature_QB extends _BaseBuilder {}

    /**
     * @method Subscribe|null getOrPut($key, $value)
     * @method Subscribe|$this shift(int $count = 1)
     * @method Subscribe|null firstOrFail($key = null, $operator = null, $value = null)
     * @method Subscribe|$this pop(int $count = 1)
     * @method Subscribe|null pull($key, $default = null)
     * @method Subscribe|null last(callable $callback = null, $default = null)
     * @method Subscribe|$this random($number = null)
     * @method Subscribe|null sole($key = null, $operator = null, $value = null)
     * @method Subscribe|null get($key, $default = null)
     * @method Subscribe|null first(callable $callback = null, $default = null)
     * @method Subscribe|null firstWhere(callable|string $key, $operator = null, $value = null)
     * @method Subscribe|null find($key, $default = null)
     * @method Subscribe[] all()
     */
    class _IH_Subscribe_C extends _BaseCollection {
        /**
         * @param int $size
         * @return Subscribe[][]
         */
        public function chunk($size)
        {
            return [];
        }
    }

    /**
     * @method Subscribe baseSole(array|string $columns = ['*'])
     * @method Subscribe create(array $attributes = [])
     * @method _IH_Subscribe_C|Subscribe[] cursor()
     * @method Subscribe|null|_IH_Subscribe_C|Subscribe[] find($id, array|string $columns = ['*'])
     * @method _IH_Subscribe_C|Subscribe[] findMany(array|Arrayable $ids, array|string $columns = ['*'])
     * @method Subscribe|_IH_Subscribe_C|Subscribe[] findOr($id, array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Subscribe|_IH_Subscribe_C|Subscribe[] findOrFail($id, array|string $columns = ['*'])
     * @method Subscribe|_IH_Subscribe_C|Subscribe[] findOrNew($id, array|string $columns = ['*'])
     * @method Subscribe first(array|string $columns = ['*'])
     * @method Subscribe firstOr(array|\Closure|string $columns = ['*'], \Closure $callback = null)
     * @method Subscribe firstOrCreate(array $attributes = [], array $values = [])
     * @method Subscribe firstOrFail(array|string $columns = ['*'])
     * @method Subscribe firstOrNew(array $attributes = [], array $values = [])
     * @method Subscribe firstWhere(array|\Closure|Expression|string $column, $operator = null, $value = null, string $boolean = 'and')
     * @method Subscribe forceCreate(array $attributes)
     * @method _IH_Subscribe_C|Subscribe[] fromQuery(string $query, array $bindings = [])
     * @method _IH_Subscribe_C|Subscribe[] get(array|string $columns = ['*'])
     * @method Subscribe getModel()
     * @method Subscribe[] getModels(array|string $columns = ['*'])
     * @method _IH_Subscribe_C|Subscribe[] hydrate(array $items)
     * @method Subscribe make(array $attributes = [])
     * @method Subscribe newModelInstance(array $attributes = [])
     * @method LengthAwarePaginator|Subscribe[]|_IH_Subscribe_C paginate(\Closure|int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Paginator|Subscribe[]|_IH_Subscribe_C simplePaginate(int|null $perPage = null, array|string $columns = ['*'], string $pageName = 'page', int|null $page = null)
     * @method Subscribe sole(array|string $columns = ['*'])
     * @method Subscribe updateOrCreate(array $attributes, array $values = [])
     */
    class _IH_Subscribe_QB extends _BaseBuilder {}

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
