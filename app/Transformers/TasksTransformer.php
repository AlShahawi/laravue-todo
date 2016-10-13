<?php

namespace App\Transformers;

class TasksTransformer extends Transformer
{
    /**
     * Transform a book.
     * @param  array $book
     * @return array
     */
    public function transform($task)
    {
        if(! $task) return null;

        return [
            'id' => $task['id'],
            'body' => $task['body'],
            'color' => $task['color'],
            'completed' => (boolean)$task['completed'],
            'created_at' => (string)$task['created_at']
        ];
    }
}
