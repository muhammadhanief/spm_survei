<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entry;

class Answer extends Model
{
    /**
     * Answer constructor.
     *
     * @param  array  $attributes
     */
    // public function __construct(array $attributes = [])
    // {
    //     if (!isset($this->table)) {
    //         $this->setTable(config('survey.database.tables.answers'));
    //     }

    //     $this->casts['value'] = get_class(app(Value::class));

    //     parent::__construct($attributes);
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['value', 'question_id', 'entry_id'];

    /**
     * The entry the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * The question the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
