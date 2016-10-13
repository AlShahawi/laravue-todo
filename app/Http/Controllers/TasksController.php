<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\TaskRequest;
use App\Task;
use App\Transformers\TasksTransformer;

class TasksController extends ApiController
{
    /**
     * tasks transformer.
     * @var App\Transformers\TasksTransformer
     */
    private $transformer;

    /**
     * controller constructor.
     */
    public function __construct(TasksTransformer $transformer)
    {
        // TODO: remove the following line.
        sleep(2);
        $this->middleware('auth:api');
        $this->transformer = $transformer;
    }

    /**
     * list all tasks for current user.
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->latest()->paginate(9);

        $transformedTasks = $this->transformer->transformCollection($tasks);

        return $this->respondWithData($transformedTasks);
    }

    /**
     * get task.
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $task = $request->user()->tasks()->find($id);

        return $this->respondOrFail($this->transformer->transform($task));
    }

    /**
     * store new task
     * @param  TaskRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->all());
        $transformedTask = $this->transformer->transform($task);

        return $this->setStatusCode(201)
                    ->respondWithData($transformedTask);
    }

    /**
     * remove task.
     * @param  Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $task = $request->user()->tasks()->where('id', $id)->first();
        if(! $task)
            return $this->respondNotFound();

        $task->delete();

        return $this->respondWithSuccess();
    }

    /**
     * update task (true or false)
     * @param  Request $request
     * @param  integer  $id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = $request->user()->tasks()->where('id', $id)->first();
        if(! $task)
            return $this->respondNotFound();

        $task->update($request->all());

        $transformedTask = $this->transformer->transform($task);

        return $this->respondWithData($transformedTask);
    }
    /**
     * mark task as completed
     * @param  Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsCompleted(Request $request, $id)
    {
        return $this->markAs($request, $id, true);
    }
}
