<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 *
 * Represents a task in the system.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string|null $due_date
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDueDateAttribute($value)
    {
        return $value ? date('d/m/Y', strtotime($value)) : null;
    }

    public function setDueDateAttribute($value)
    {
        if ($value instanceof \DateTime) {
            $this->attributes['due_date'] = $value->format('Y-m-d');
        } elseif (is_string($value)) {
            $this->attributes['due_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        } else {
            $this->attributes['due_date'] = null;
        }
    }
}
