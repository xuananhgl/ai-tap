<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags'); 
    }

    public function beforeSave($event, $entity, $options)
{
    if ($entity->isNew() && !$entity->slug) {
        $sluggedTitle = Text::slug($entity->title);
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 191);
    }
}
public function validationDefault(Validator $validator)
{
    $validator
        ->allowEmptyString('title', 'Title cannot be empty', false)
        ->minLength('title', 5)
        ->maxLength('title', 255);

    $validator
        ->allowEmptyString('body', 'Body cannot be empty', false)
        ->minLength('body', 5);
    $validator
        ->allowEmptyString('Tags', 'Body cannot be empty', false)
        ->minLength('body', 5);

    return $validator;
}
}