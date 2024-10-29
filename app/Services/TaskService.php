<?php

namespace App\Services;

use Exception;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    /**
     * جلب جميع المهام مع الفلترة حسب الحالة.
     *
     * @param string|null $status حالة المهمة (Pending, Completed)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTasks($status = null)
    {
        try {

            $cacheKey = $status ? "tasks_{$status}" : 'tasks_all';


            return Cache::remember($cacheKey, 60 * 5, function () use ($status) {
                $query = Task::query();


                if ($status) {
                    $query->where('status', $status);
                }

                return $query->get();
            });
        } catch (Exception $e) {
            Log::error("Failed to get tasks: {$e->getMessage()}");
            return collect(); 
        }
    }

    /**
     * إنشاء مهمة جديدة.
     *
     * @param array $data بيانات المهمة
     * @return \App\Models\Task|null
     */
    public function createTask(array $data)
    {
        try {
            DB::beginTransaction();
            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'due_date' =>  $data['due_date'],
                'status' =>  $data['status'],
                'user_id' => Auth::id()
            ]);
            Cache::forget('tasks_all');
            DB::commit();
            return $task;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create task: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * تحديث مهمة قائمة.
     *
     * @param \App\Models\Task $task المهمة المراد تحديثها
     * @param array $data بيانات المهمة الجديدة
     * @return bool
     */
    public function updateTask(Task $task, array $data)
    {
        try {
            DB::beginTransaction();
            $result = $task->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'due_date' =>  $data['due_date'],
                'status' =>  $data['status'],
                'user_id' => Auth::id()
            ]);
            Cache::forget('tasks_all');
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to update task: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * حذف مهمة.
     *
     * @param \App\Models\Task $task المهمة المراد حذفها
     * @return bool
     */
    public function deleteTask(Task $task)
    {
        try {
            $result = $task->delete();
            Cache::forget('tasks_all');
            return $result;
        } catch (Exception $e) {
            Log::error("Failed to delete task: {$e->getMessage()}");
            return false;
        }
    }
}
