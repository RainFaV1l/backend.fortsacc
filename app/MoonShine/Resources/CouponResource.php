<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;
use App\MoonShine\Pages\Coupon\CouponIndexPage;
use App\MoonShine\Pages\Coupon\CouponFormPage;
use App\MoonShine\Pages\Coupon\CouponDetailPage;

use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Coupon>
 */
class CouponResource extends ModelResource
{
    protected string $model = Coupon::class;

    protected string $title = 'Купоны';

    public function pages(): array
    {
        return [
            CouponIndexPage::make($this->title()),
            CouponFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            CouponDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255|unique:coupons,name',
            'percent' => 'required|integer|max:100|min:1',
            'expired_at' => 'nullable|date',
        ];
    }
}
