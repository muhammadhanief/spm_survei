<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\Section;
use App\Models\Survey;
use App\Models\Dimension;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\QuestionType;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'questions';
    protected $fillable = ['type', 'options', 'content', 'rules', 'survey_id', 'dimension_id', 'question_type_id'];

    protected $casts = [
        'rules' => 'array',
        'options' => 'array',
    ];

    /**
     * Boot the question.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //Ensure the question's survey is the same as the section it belongs to.
        static::creating(function (self $question) {
            $question->load('section');

            if ($question->section) {
                $question->survey_id = $question->section->survey_id;
            }
        });
    }

    /**
     * Question constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (!isset($this->table)) {
            $this->setTable(config('survey.database.tables.questions'));
        }

        parent::__construct($attributes);
    }

    /**
     * The survey the question belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'dimension_id');
    }

    /**
     * The survey the question type belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    /**
     * The survey the question belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * The section the question belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * The answers that belong to the question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The question's validation rules.
     *
     * @param $value
     * @return array|mixed
     */
    public function getRulesAttribute($value)
    {
        $value = $this->castAttribute('rules', $value);

        return $value !== null ? $value : [];
    }

    /**
     * The unique key representing the question.
     *
     * @return string
     */
    public function getKeyAttribute()
    {
        return "q{$this->id}";
    }

    /**
     * Scope a query to only include questions that
     * don't belong to any sections.
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithoutSection($query)
    {
        return $query->where('section_id', null);
    }
}
