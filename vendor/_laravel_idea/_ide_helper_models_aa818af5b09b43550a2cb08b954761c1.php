<?php //78d332e80230572e6ccfa349d481884c
/** @noinspection all */

namespace TCG\Voyager\Tests {

    use Illuminate\Database\Eloquent\Model;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_ActuallyTranslatableModel_C;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_ActuallyTranslatableModel_QB;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_NotTranslatableModel_C;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_NotTranslatableModel_QB;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_StillNotTranslatableModel_C;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_StillNotTranslatableModel_QB;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_TranslatableModel_C;
    use LaravelIdea\Helper\TCG\Voyager\Tests\_IH_TranslatableModel_QB;

    /**
     * @method static _IH_ActuallyTranslatableModel_QB onWriteConnection()
     * @method _IH_ActuallyTranslatableModel_QB newQuery()
     * @method static _IH_ActuallyTranslatableModel_QB on(null|string $connection = null)
     * @method static _IH_ActuallyTranslatableModel_QB query()
     * @method static _IH_ActuallyTranslatableModel_QB with(array|string $relations)
     * @method _IH_ActuallyTranslatableModel_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_ActuallyTranslatableModel_C|ActuallyTranslatableModel[] all()
     * @mixin _IH_ActuallyTranslatableModel_QB
     */
    class ActuallyTranslatableModel extends Model {}

    /**
     * @method static _IH_NotTranslatableModel_QB onWriteConnection()
     * @method _IH_NotTranslatableModel_QB newQuery()
     * @method static _IH_NotTranslatableModel_QB on(null|string $connection = null)
     * @method static _IH_NotTranslatableModel_QB query()
     * @method static _IH_NotTranslatableModel_QB with(array|string $relations)
     * @method _IH_NotTranslatableModel_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_NotTranslatableModel_C|NotTranslatableModel[] all()
     * @mixin _IH_NotTranslatableModel_QB
     */
    class NotTranslatableModel extends Model {}

    /**
     * @method static _IH_StillNotTranslatableModel_QB onWriteConnection()
     * @method _IH_StillNotTranslatableModel_QB newQuery()
     * @method static _IH_StillNotTranslatableModel_QB on(null|string $connection = null)
     * @method static _IH_StillNotTranslatableModel_QB query()
     * @method static _IH_StillNotTranslatableModel_QB with(array|string $relations)
     * @method _IH_StillNotTranslatableModel_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_StillNotTranslatableModel_C|StillNotTranslatableModel[] all()
     * @mixin _IH_StillNotTranslatableModel_QB
     */
    class StillNotTranslatableModel extends Model {}

    /**
     * @method static _IH_TranslatableModel_QB onWriteConnection()
     * @method _IH_TranslatableModel_QB newQuery()
     * @method static _IH_TranslatableModel_QB on(null|string $connection = null)
     * @method static _IH_TranslatableModel_QB query()
     * @method static _IH_TranslatableModel_QB with(array|string $relations)
     * @method _IH_TranslatableModel_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_TranslatableModel_C|TranslatableModel[] all()
     * @mixin _IH_TranslatableModel_QB
     */
    class TranslatableModel extends Model {}
}
