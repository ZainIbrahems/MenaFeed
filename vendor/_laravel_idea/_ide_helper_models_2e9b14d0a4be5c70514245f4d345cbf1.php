<?php //c090c64a210673655d44122f16cb327e
/** @noinspection all */

namespace TCG\Voyager\Models {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Category_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Category_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_DataRow_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_DataRow_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_DataType_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_DataType_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_MenuItem_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_MenuItem_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Menu_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Menu_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Page_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Page_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Permission_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Permission_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Post_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Post_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Role_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Role_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Setting_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Setting_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Translation_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_Translation_QB;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_User_C;
    use LaravelIdea\Helper\TCG\Voyager\Models\_IH_User_QB;
    use TCG\Voyager\Tests\Database\Factories\RoleFactory;
    use TCG\Voyager\Tests\Database\Factories\UserFactory;

    /**
     * @property Category $parentId
     * @method BelongsTo|_IH_Category_QB parentId()
     * @method static _IH_Category_QB onWriteConnection()
     * @method _IH_Category_QB newQuery()
     * @method static _IH_Category_QB on(null|string $connection = null)
     * @method static _IH_Category_QB query()
     * @method static _IH_Category_QB with(array|string $relations)
     * @method _IH_Category_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Category_C|Category[] all()
     * @mixin _IH_Category_QB
     */
    class Category extends Model {}

    /**
     * @method static _IH_DataRow_QB onWriteConnection()
     * @method _IH_DataRow_QB newQuery()
     * @method static _IH_DataRow_QB on(null|string $connection = null)
     * @method static _IH_DataRow_QB query()
     * @method static _IH_DataRow_QB with(array|string $relations)
     * @method _IH_DataRow_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_DataRow_C|DataRow[] all()
     * @mixin _IH_DataRow_QB
     */
    class DataRow extends Model {}

    /**
     * @property null $default_search_key attribute
     * @property null $order_column attribute
     * @property string $order_direction attribute
     * @property null $order_display_column attribute
     * @property null $scope attribute
     * @method static _IH_DataType_QB onWriteConnection()
     * @method _IH_DataType_QB newQuery()
     * @method static _IH_DataType_QB on(null|string $connection = null)
     * @method static _IH_DataType_QB query()
     * @method static _IH_DataType_QB with(array|string $relations)
     * @method _IH_DataType_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_DataType_C|DataType[] all()
     * @mixin _IH_DataType_QB
     */
    class DataType extends Model {}

    /**
     * @method static _IH_Menu_QB onWriteConnection()
     * @method _IH_Menu_QB newQuery()
     * @method static _IH_Menu_QB on(null|string $connection = null)
     * @method static _IH_Menu_QB query()
     * @method static _IH_Menu_QB with(array|string $relations)
     * @method _IH_Menu_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Menu_C|Menu[] all()
     * @mixin _IH_Menu_QB
     */
    class Menu extends Model {}

    /**
     * @property $parameters attribute
     * @method static _IH_MenuItem_QB onWriteConnection()
     * @method _IH_MenuItem_QB newQuery()
     * @method static _IH_MenuItem_QB on(null|string $connection = null)
     * @method static _IH_MenuItem_QB query()
     * @method static _IH_MenuItem_QB with(array|string $relations)
     * @method _IH_MenuItem_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_MenuItem_C|MenuItem[] all()
     * @mixin _IH_MenuItem_QB
     */
    class MenuItem extends Model {}

    /**
     * @method static _IH_Page_QB onWriteConnection()
     * @method _IH_Page_QB newQuery()
     * @method static _IH_Page_QB on(null|string $connection = null)
     * @method static _IH_Page_QB query()
     * @method static _IH_Page_QB with(array|string $relations)
     * @method _IH_Page_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Page_C|Page[] all()
     * @mixin _IH_Page_QB
     */
    class Page extends Model {}

    /**
     * @method static _IH_Permission_QB onWriteConnection()
     * @method _IH_Permission_QB newQuery()
     * @method static _IH_Permission_QB on(null|string $connection = null)
     * @method static _IH_Permission_QB query()
     * @method static _IH_Permission_QB with(array|string $relations)
     * @method _IH_Permission_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Permission_C|Permission[] all()
     * @mixin _IH_Permission_QB
     */
    class Permission extends Model {}

    /**
     * @method static _IH_Post_QB onWriteConnection()
     * @method _IH_Post_QB newQuery()
     * @method static _IH_Post_QB on(null|string $connection = null)
     * @method static _IH_Post_QB query()
     * @method static _IH_Post_QB with(array|string $relations)
     * @method _IH_Post_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Post_C|Post[] all()
     * @mixin _IH_Post_QB
     */
    class Post extends Model {}

    /**
     * @method static _IH_Role_QB onWriteConnection()
     * @method _IH_Role_QB newQuery()
     * @method static _IH_Role_QB on(null|string $connection = null)
     * @method static _IH_Role_QB query()
     * @method static _IH_Role_QB with(array|string $relations)
     * @method _IH_Role_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Role_C|Role[] all()
     * @mixin _IH_Role_QB
     * @method static RoleFactory factory(array|callable|int|null $count = null, array|callable $state = [])
     */
    class Role extends Model {}

    /**
     * @method static _IH_Setting_QB onWriteConnection()
     * @method _IH_Setting_QB newQuery()
     * @method static _IH_Setting_QB on(null|string $connection = null)
     * @method static _IH_Setting_QB query()
     * @method static _IH_Setting_QB with(array|string $relations)
     * @method _IH_Setting_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Setting_C|Setting[] all()
     * @mixin _IH_Setting_QB
     */
    class Setting extends Model {}

    /**
     * @method static _IH_Translation_QB onWriteConnection()
     * @method _IH_Translation_QB newQuery()
     * @method static _IH_Translation_QB on(null|string $connection = null)
     * @method static _IH_Translation_QB query()
     * @method static _IH_Translation_QB with(array|string $relations)
     * @method _IH_Translation_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Translation_C|Translation[] all()
     * @mixin _IH_Translation_QB
     */
    class Translation extends Model {}

    /**
     * @property int $id
     * @property string $name
     * @property string $email
     * @property Carbon|null $email_verified_at
     * @property string $password
     * @property string|null $remember_token
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property $locale attribute
     * @method static _IH_User_QB onWriteConnection()
     * @method _IH_User_QB newQuery()
     * @method static _IH_User_QB on(null|string $connection = null)
     * @method static _IH_User_QB query()
     * @method static _IH_User_QB with(array|string $relations)
     * @method _IH_User_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_User_C|User[] all()
     * @mixin _IH_User_QB
     * @method static UserFactory factory(array|callable|int|null $count = null, array|callable $state = [])
     */
    class User extends Model {}
}
