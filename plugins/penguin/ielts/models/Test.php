<?php namespace Penguin\Ielts\Models;

use Model;

/**
 * Test Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Test extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'penguin_ielts_tests';

    /**
     * @var array rules for validation
     */
    public $rules = [];

    public $belongsToMany = [
        'questions' => [
            Questions::class,
            'table' => 'penguin_ielts_test_question',
            'key'      => 'test_id',
            'otherKey' => 'question_id',
            'order' => 'sort_order',
        ],
    ];
}
