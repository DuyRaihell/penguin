<?php namespace Penguin\Ielts\Models;

use Model;

/**
 * Test Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Answer extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'penguin_ielts_answers';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    public $belongsTo = [
        'question' => Questions::class
    ];
}
