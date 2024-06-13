<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartStatus;
use App\Models\Coupon;
use App\Models\MysteryBox;
use App\Models\MysteryBoxParticipant;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Order;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\RelatedNews;
use App\Models\Review;
use App\Models\SliderProduct;
use App\Models\User;
use App\MoonShine\Resources\CartResource;
use App\MoonShine\Resources\CartStatusResource;
use App\MoonShine\Resources\CouponResource;
use App\MoonShine\Resources\MysteryBoxParticipantResource;
use App\MoonShine\Resources\MysteryBoxResource;
use App\MoonShine\Resources\NewsCategoryResource;
use App\MoonShine\Resources\NewsResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\PopularProductResource;
use App\MoonShine\Resources\ProductCategoryResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\RelatedNewsResource;
use App\MoonShine\Resources\ReviewResource;
use App\MoonShine\Resources\SliderResource;
use App\MoonShine\Resources\UserResource;
use MoonShine\Models\MoonshineUser;
use MoonShine\Models\MoonshineUserRole;
use MoonShine\Providers\MoonShineApplicationServiceProvider;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            MenuGroup::make('Системные', [
                MenuItem::make(
                    static fn() => __('moonshine::ui.resource.admins_title'),
                    new MoonShineUserResource()
                )->badge(fn() => MoonshineUser::query()->count()),
                MenuItem::make(
                    static fn() => __('moonshine::ui.resource.role_title'),
                    new MoonShineUserRoleResource()
                )->badge(fn() => MoonshineUserRole::query()->count()),
            ]),
            MenuGroup::make('Продукты', [
                MenuItem::make('Продукт', new ProductResource())->icon('heroicons.outline.shopping-bag')->badge(fn() => Product::query()->count()),
                MenuItem::make('Категория', new ProductCategoryResource())->icon('heroicons.outline.tag')->badge(fn() => ProductCategory::query()->count()),
                MenuItem::make('Популярные', new PopularProductResource())->icon('heroicons.outline.bookmark')->badge(fn() => PopularProduct::query()->count()),
                MenuItem::make('Слайдер', new SliderResource())->icon('heroicons.outline.queue-list')->badge(fn() => SliderProduct::query()->count()),
            ]),
            MenuGroup::make('Новости', [
                MenuItem::make('Категории', new NewsCategoryResource())->icon('heroicons.outline.tag')->badge(fn() => NewsCategory::query()->count()),
                MenuItem::make('Новости', new NewsResource())->icon('heroicons.outline.newspaper')->badge(fn() => News::query()->count()),
                MenuItem::make('Связанные новости', new RelatedNewsResource())->icon('heroicons.outline.clipboard-document-list')->badge(fn() => RelatedNews::query()->count()),
            ]),
            MenuGroup::make('Пользователи', [
                MenuItem::make('Пользователь', new UserResource())->icon('heroicons.outline.user')->badge(fn() => User::query()->count()),
                MenuItem::make('Отзывы', new ReviewResource())->icon('heroicons.outline.hand-thumb-up')->badge(fn() => Review::query()->count()),
            ]),
            MenuGroup::make('Mystery Box', [
                MenuItem::make('Розыгрыш', new MysteryBoxResource())->icon('heroicons.outline.gift')->badge(fn() => MysteryBox::query()->count()),
                MenuItem::make('Участники', new MysteryBoxParticipantResource())->icon('heroicons.outline.users')->badge(fn() => MysteryBoxParticipant::query()->count()),
            ]),
            MenuGroup::make('Заказы', [
                MenuItem::make('Купоны', new CouponResource())->icon('heroicons.outline.receipt-percent')->badge(fn() => Coupon::query()->count()),
                MenuItem::make('Статус корзины', new CartStatusResource())->icon('heroicons.outline.chart-bar')->badge(fn() => CartStatus::query()->count()),
                MenuItem::make('Корзина', new CartResource())->icon('heroicons.outline.shopping-bag')->badge(fn() => Cart::query()->count()),
                MenuItem::make('Заказ', new OrderResource())->icon('heroicons.outline.gift')->badge(fn() => Order::query()->count()),
            ]),
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
