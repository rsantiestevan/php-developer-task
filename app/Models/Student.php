<?php

namespace App\Models;

use App\Models\Course;
use App\Models\StudentAddresses;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Student extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student';

    public $timestamps = false;

    protected $hidden = ['address_id', 'created_at', 'updated_at'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'id', 'course_id');
    }

    public function address()
    {
        return $this->hasOne(StudentAddress::class, 'id');
    }
    
    /**
     * Generate the data for the report
     * 
     * @param array $whereValues
     * @return array data for the report
     */
    public static function generateReport($whereValues){
        $students = DB::table('student')
                    ->join('course', 'course.id', '=', 'student.course_id')
                    ->select(self::_getFieldNames())
                    ->whereIn('student.id', $whereValues)
                    ->get();
        $listData = [];
        foreach ($students as $student) {
            $listData[] = array($student->firstname, $student->surname, $student->email, $student->university, $student->course_name);
        }
        return $listData;
    }
    
    /**
     * 
     * @return array 
     */
    public static function getFieldNames(){
        return ['Forename', 'Surname', 'Email', 'University', 'Course'];
    }
    
    /**
     * 
     * @return array 
     */
    public static function _getFieldNames(){
        return ['firstname', 'surname', 'email', 'university', 'course_name'];
    }
}
