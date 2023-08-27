<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BudgetUsage extends Model implements HasMedia
{
    use HasFactory;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;
    use SoftDeletes;
 
    protected $fillable = [
        'created_by',
        'updated_by',
        'budget_id',
        'budget_detail_id',

        'divisi',
        'tanggal',
        'jenis_budget',
        'deskripsi',
        'jumlah_orang',
        'total',
        'reimburs',
    ];
    
    
    protected $dates = [
        'tanggal',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $appends = ['resource_url', 'bon_transaksi'];

    /* ************************ MEDIA ************************ */
    /**
     * Get url of avatar image
     *
     * @return string|null
     */
    // public function getAvatarThumbUrlAttribute(): ?string
    // {
    //     return $this->getFirstMediaUrl('avatar', 'thumb_150') ?: null;
    // }

    public function getBonTransaksiAttribute(): ?string
    {
        return $this->getFirstMediaUrl('bon_transaksi', 'thumb_150') ?: null;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(app(ResetPassword::class, ['token' => $token]));
    }

    /* ************************ MEDIA ************************ */

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bon_transaksi')
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();

        $this->addMediaConversion('thumb_75')
            ->optimize()
            ->performOnCollections('bon_transaksi')
            ->nonQueued();

        $this->addMediaConversion('thumb_150')
            ->optimize()
            ->performOnCollections('bon_transaksi')
            ->nonQueued();
    }

    /**
     * Auto register thumb overridden
     */
    public function autoRegisterThumb200()
    {
        $this->getMediaCollections()->filter->isImage()->each(function ($mediaCollection) {
            $this->addMediaConversion('thumb_200')
                ->width(200)
                ->height(200)
                ->fit('crop', 200, 200)
                ->optimize()
                ->performOnCollections($mediaCollection->getName())
                ->nonQueued();
        });
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/budget-usages/'.$this->getKey().'/'.$this->divisi);
    }
}
