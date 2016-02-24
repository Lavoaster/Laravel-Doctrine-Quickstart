<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Task;
use App\Domain\Repositories\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Validation\Factory as ValidatorFactory;

class TasksController extends Controller
{
    public function index(TaskRepository $repository)
    {
        return view('tasks', [
            'tasks' => $repository->all('createdAt', 'ASC')
        ]);
    }

    public function store(Request $request, EntityManagerInterface $em, ValidatorFactory $validatorFactory)
    {
        $validator = $validatorFactory->make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $task = new Task(
            $request->get('name')
        );

        $em->persist($task);

        return redirect('/');
    }

    public function delete($id, TaskRepository $repository, EntityManagerInterface $em)
    {
        $task = $repository->find($id);

        $em->remove($task);

        return redirect('/');
    }
}
