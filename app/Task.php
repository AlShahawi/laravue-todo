<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    /**
     * fillable attributes to protect against miss assignment exception.
     * @var array
     */
    protected $fillable = ['id', 'body', 'user_id', 'completed', 'color'];

    /**
     * user belongs to the task.
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
