<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id', 'created_at'];

    public function class()
    {
        return $this->hasMany(TeacherClass::class);
    }

    public function subject()
    {
        return $this->hasMany(TeacherSubject::class);
    }


    public function createTeacher($data)
    {
        $teacher = $this->create($data);
        $this->associateFields($data, $teacher);
    }


    public function updateTeacher($data)
    {
        $teacher = $this->find($data['id']);
        $teacher->update($data);
        $this->associateFields($data, $teacher);
    }


    public function associateFields($data, $teacher)
    {
        if (isset($data['classes']) && is_array($data['classes'])) {
            $classes = [];
            foreach ($data['classes'] as $class => $value) {
                if ($value) {
                    $classes[] = ['class' => $class];
                }
            }

            $teacher->class()->delete();
            $teacher->class()->createMany($classes);
        }

        if (isset($data['subjects']) && is_array($data['subjects'])) {
            $subjects = [];
            foreach ($data['subjects'] as $subject => $value) {
                if ($value) {
                    $subjects[] = ['subject' => $subject];
                }
            }

            $teacher->subject()->delete();
            $teacher->subject()->createMany($subjects);
        }
    }
}
