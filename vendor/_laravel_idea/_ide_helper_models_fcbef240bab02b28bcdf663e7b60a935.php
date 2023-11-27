<?php //894146c3ba5b3c0f864fd9e0af4892e3
/** @noinspection all */

namespace App\Models {

    use Database\Factories\UserFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\MorphToMany;
    use Illuminate\Notifications\DatabaseNotification;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\_IH_Authority_C;
    use LaravelIdea\Helper\App\Models\_IH_Authority_QB;
    use LaravelIdea\Helper\App\Models\_IH_Brand_C;
    use LaravelIdea\Helper\App\Models\_IH_Brand_QB;
    use LaravelIdea\Helper\App\Models\_IH_CardAdvantage_C;
    use LaravelIdea\Helper\App\Models\_IH_CardAdvantage_QB;
    use LaravelIdea\Helper\App\Models\_IH_CardsCardAdvantage_C;
    use LaravelIdea\Helper\App\Models\_IH_CardsCardAdvantage_QB;
    use LaravelIdea\Helper\App\Models\_IH_Card_C;
    use LaravelIdea\Helper\App\Models\_IH_Card_QB;
    use LaravelIdea\Helper\App\Models\_IH_City_C;
    use LaravelIdea\Helper\App\Models\_IH_City_QB;
    use LaravelIdea\Helper\App\Models\_IH_Country_C;
    use LaravelIdea\Helper\App\Models\_IH_Country_QB;
    use LaravelIdea\Helper\App\Models\_IH_Message_C;
    use LaravelIdea\Helper\App\Models\_IH_Message_QB;
    use LaravelIdea\Helper\App\Models\_IH_Offer_C;
    use LaravelIdea\Helper\App\Models\_IH_Offer_QB;
    use LaravelIdea\Helper\App\Models\_IH_SpecialFeature_C;
    use LaravelIdea\Helper\App\Models\_IH_SpecialFeature_QB;
    use LaravelIdea\Helper\App\Models\_IH_Subscribe_C;
    use LaravelIdea\Helper\App\Models\_IH_Subscribe_QB;
    use LaravelIdea\Helper\App\Models\_IH_User_C;
    use LaravelIdea\Helper\App\Models\_IH_User_QB;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_C;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_QB;

    /**
     * @method static _IH_Authority_QB onWriteConnection()
     * @method _IH_Authority_QB newQuery()
     * @method static _IH_Authority_QB on(null|string $connection = null)
     * @method static _IH_Authority_QB query()
     * @method static _IH_Authority_QB with(array|string $relations)
     * @method _IH_Authority_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Authority_C|Authority[] all()
     * @mixin _IH_Authority_QB
     */
    class Authority extends Model {}

    /**
     * @method static _IH_Brand_QB onWriteConnection()
     * @method _IH_Brand_QB newQuery()
     * @method static _IH_Brand_QB on(null|string $connection = null)
     * @method static _IH_Brand_QB query()
     * @method static _IH_Brand_QB with(array|string $relations)
     * @method _IH_Brand_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Brand_C|Brand[] all()
     * @mixin _IH_Brand_QB
     */
    class Brand extends Model {}

    /**
     * @property _IH_CardAdvantage_C|CardAdvantage[] $advantages
     * @property-read int $advantages_count
     * @method BelongsToMany|_IH_CardAdvantage_QB advantages()
     * @method static _IH_Card_QB onWriteConnection()
     * @method _IH_Card_QB newQuery()
     * @method static _IH_Card_QB on(null|string $connection = null)
     * @method static _IH_Card_QB query()
     * @method static _IH_Card_QB with(array|string $relations)
     * @method _IH_Card_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Card_C|Card[] all()
     * @mixin _IH_Card_QB
     */
    class Card extends Model {}

    /**
     * @method static _IH_CardAdvantage_QB onWriteConnection()
     * @method _IH_CardAdvantage_QB newQuery()
     * @method static _IH_CardAdvantage_QB on(null|string $connection = null)
     * @method static _IH_CardAdvantage_QB query()
     * @method static _IH_CardAdvantage_QB with(array|string $relations)
     * @method _IH_CardAdvantage_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_CardAdvantage_C|CardAdvantage[] all()
     * @mixin _IH_CardAdvantage_QB
     */
    class CardAdvantage extends Model {}

    /**
     * @method static _IH_CardsCardAdvantage_QB onWriteConnection()
     * @method _IH_CardsCardAdvantage_QB newQuery()
     * @method static _IH_CardsCardAdvantage_QB on(null|string $connection = null)
     * @method static _IH_CardsCardAdvantage_QB query()
     * @method static _IH_CardsCardAdvantage_QB with(array|string $relations)
     * @method _IH_CardsCardAdvantage_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_CardsCardAdvantage_C|CardsCardAdvantage[] all()
     * @mixin _IH_CardsCardAdvantage_QB
     */
    class CardsCardAdvantage extends Model {}

    /**
     * @method static _IH_City_QB onWriteConnection()
     * @method _IH_City_QB newQuery()
     * @method static _IH_City_QB on(null|string $connection = null)
     * @method static _IH_City_QB query()
     * @method static _IH_City_QB with(array|string $relations)
     * @method _IH_City_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_City_C|City[] all()
     * @mixin _IH_City_QB
     */
    class City extends Model {}

    /**
     * @method static _IH_Country_QB onWriteConnection()
     * @method _IH_Country_QB newQuery()
     * @method static _IH_Country_QB on(null|string $connection = null)
     * @method static _IH_Country_QB query()
     * @method static _IH_Country_QB with(array|string $relations)
     * @method _IH_Country_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Country_C|Country[] all()
     * @mixin _IH_Country_QB
     */
    class Country extends Model {}

    /**
     * @method static _IH_Message_QB onWriteConnection()
     * @method _IH_Message_QB newQuery()
     * @method static _IH_Message_QB on(null|string $connection = null)
     * @method static _IH_Message_QB query()
     * @method static _IH_Message_QB with(array|string $relations)
     * @method _IH_Message_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Message_C|Message[] all()
     * @mixin _IH_Message_QB
     */
    class Message extends Model {}

    /**
     * @property Card $card
     * @method BelongsTo|_IH_Card_QB card()
     * @property User $partner
     * @method BelongsTo|_IH_User_QB partner()
     * @method static _IH_Offer_QB onWriteConnection()
     * @method _IH_Offer_QB newQuery()
     * @method static _IH_Offer_QB on(null|string $connection = null)
     * @method static _IH_Offer_QB query()
     * @method static _IH_Offer_QB with(array|string $relations)
     * @method _IH_Offer_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Offer_C|Offer[] all()
     * @mixin _IH_Offer_QB
     */
    class Offer extends Model {}

    /**
     * @method static _IH_SpecialFeature_QB onWriteConnection()
     * @method _IH_SpecialFeature_QB newQuery()
     * @method static _IH_SpecialFeature_QB on(null|string $connection = null)
     * @method static _IH_SpecialFeature_QB query()
     * @method static _IH_SpecialFeature_QB with(array|string $relations)
     * @method _IH_SpecialFeature_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_SpecialFeature_C|SpecialFeature[] all()
     * @mixin _IH_SpecialFeature_QB
     */
    class SpecialFeature extends Model {}

    /**
     * @property Card $card
     * @method BelongsTo|_IH_Card_QB card()
     * @property City $city
     * @method BelongsTo|_IH_City_QB city()
     * @property Country $country
     * @method BelongsTo|_IH_Country_QB country()
     * @method static _IH_Subscribe_QB onWriteConnection()
     * @method _IH_Subscribe_QB newQuery()
     * @method static _IH_Subscribe_QB on(null|string $connection = null)
     * @method static _IH_Subscribe_QB query()
     * @method static _IH_Subscribe_QB with(array|string $relations)
     * @method _IH_Subscribe_QB newModelQuery()
     * @method false|int increment(string $column, float|int $amount = 1, array $extra = [])
     * @method false|int decrement(string $column, float|int $amount = 1, array $extra = [])
     * @method static _IH_Subscribe_C|Subscribe[] all()
     * @mixin _IH_Subscribe_QB
     */
    class Subscribe extends Model {}

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
     * @property Authority $authority
     * @method BelongsTo|_IH_Authority_QB authority()
     * @property City $city
     * @method BelongsTo|_IH_City_QB city()
     * @property Country $country
     * @method BelongsTo|_IH_Country_QB country()
     * @property _IH_DatabaseNotification_C|DatabaseNotification[] $notifications
     * @property-read int $notifications_count
     * @method MorphToMany|_IH_DatabaseNotification_QB notifications()
     * @property _IH_DatabaseNotification_C|DatabaseNotification[] $readNotifications
     * @property-read int $read_notifications_count
     * @method MorphToMany|_IH_DatabaseNotification_QB readNotifications()
     * @property _IH_DatabaseNotification_C|DatabaseNotification[] $unreadNotifications
     * @property-read int $unread_notifications_count
     * @method MorphToMany|_IH_DatabaseNotification_QB unreadNotifications()
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
