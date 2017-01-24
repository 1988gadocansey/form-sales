<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\MessagesModel; 
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
 
class SystemController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        
    }
    public function age($birthdate, $pattern = 'eu')
        {
            $patterns = array(
                'eu'    => 'd/m/Y',
                'mysql' => 'Y-m-d',
                'us'    => 'm/d/Y',
                'gh'    => 'd-m-Y',
            );

            $now      = new \DateTime();
            $in       = \DateTime::createFromFormat($patterns[$pattern], $birthdate);
            $interval = $now->diff($in);
            return $interval->y;
        }
     public function getReligion() {
         $religion = \DB::table('tbl_religion')
                ->lists('religion', 'religion');
        return $religion;
    }
    public function getCountry() {
         $country = \DB::table('tbl_country')->orderBy("Name")->orderBy('Name')
                ->lists('Name', 'Name');
        return $country;
    }
    public function getHalls() {
         $hall = \DB::table('tpoly_hall')->orderBy("HALL_NAME")
                ->lists('HALL_NAME', 'HALL_NAME');
        return $hall;
    }
     public function getRegions() {
         $region = \DB::table('tbl_regions')
                ->lists('Name', 'Name');
        return $region;
    }
    public function getProgramByIDList() {
      if( @\Auth::user()->department=='top' || @\Auth::user()->role=='FO'){
       
         $program = \DB::table('tpoly_programme')->orderBy("PROGRAMME")
                ->lists('PROGRAMME', 'ID');
         return $program;
      }
      else{
         // $user_department= @\Auth::user()->department;
         $program = \DB::table('tpoly_programme')->orderBy("PROGRAMME")
                ->lists('PROGRAMME', 'ID');
         return $program;
      }
         
    }
     public function getDepartmentByIDList() {
         
       if( @\Auth::user()->department=='top'|| @\Auth::user()->role=='FO'){
         $department = \DB::table('tpoly_department')->orderBy("DEPARTMENT")
                ->lists('DEPARTMENT', 'ID');
         return $department;
       }
       elseif( @\Auth::user()->role=='Registrar' ){
         $user_department= @\Auth::user()->department;
           $department = \DB::table('tpoly_department')->where('FACCODE',$user_department)->orderBy("DEPARTMENT")
                ->lists('DEPARTMENT', 'ID');
         return $department;
        }
       else{
             $user_department= @\Auth::user()->department;
           $department = \DB::table('tpoly_department')->where('DEPTCODE',$user_department)
                ->lists('DEPARTMENT', 'ID');
         return $department;
       }
         
    }
    public function getDepartmentList() {
        if(@\Auth::user()->role=='Registrar'){
         $department = \DB::table('tpoly_department')->where('FACCODE',@\Auth::user()->department)->orderBy("DEPARTMENT")
                ->lists('DEPARTMENT', 'DEPTCODE');
         return $department;
        }
        elseif(@\Auth::user()->role=='Support' ||@\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Lecturer' ){
            $department = \DB::table('tpoly_department')->where('DEPTCODE',@\Auth::user()->department)->orderBy("DEPARTMENT")
                ->lists('DEPARTMENT', 'DEPTCODE');
         return $department;
        }
        else{
            $department = \DB::table('tpoly_department')->orderBy("DEPARTMENT")
                ->lists('DEPARTMENT', 'DEPTCODE');
         return $department;
        }
    }
    public function getGradeSystemIDList() {
         
         
         $grade = \DB::table('tpoly_grade_system')
                ->lists('type', 'type');
         return $grade;
       
         
    }
    public function getSchoolList() {
         
         
         $school = \DB::table('tpoly_faculty')->orderBy("FACULTY")
                ->lists('FACULTY', 'FACCODE');
         return $school;
       
         
    }
    
    public function getProgrammeTypes() {
         
         
         $school = \DB::table('tpoly_programme')->where("TYPE","!=","")->groupBy("TYPE")->orderBy("TYPE")
                ->lists('TYPE', 'TYPE');
         return $school;
       
         
    }
    
    public function getStudentAccountInfo($indexno) {
         
         
         $info = \DB::table('tpoly_log_portal')->where("username",$indexno)->first();
             if(!empty($info )){    
         return $info->biodata_update;
             }
         
    }
    public function getYearBill($year,$level,$program) {
         
         
         $fee = \DB::table('tpoly_bills')->where("PROGRAMME",$program)
                 ->where('LEVEL',$level)
                  ->where('YEAR',$year)
                 ->first();
         
                if(!empty($fee)){
         return $fee->AMOUNT;
                }
                else{
                   throw new HttpException(Response::HTTP_UNAUTHORIZED, 'The program that you are adding the student does not have school fees in the system.create the school fee for the program first. Go back');
      
                    }
       
         
    }
    public function getYearBillInject($year,$level,$program) {
         
         
         $fee = \DB::table('tpoly_bills')->where("PROGRAMME",$program)
                 ->where('LEVEL',$level)
                  ->where('YEAR',$year)
                 ->first();
         
                if(!empty($fee)){
         return $fee->AMOUNT;
                }
                else{
                  return 0;
                    }
       
         
    }
    public function graduatingGroup($indexNo) {
         $level= substr($indexNo, 2,2);
         $group="20".$level;
         $group_=($group + 3)."/".($group + 4);
         
         return $group_;
               
    }
    public function getProgramDepartment($program){
        
        $department = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$program)->get();
                 
        return @$department[0]->DEPTCODE;
     
    }
     public function getClass($cgpa){
        
        $class = \DB::table('tpoly_classes')->where('lowerBoundary','<=',$cgpa)
                ->where("upperBoundary",">=",$cgpa)
                ->first();
                 
        return @$class->class;
     
    }
    public function getLecturer($lecturer){
        
        $staff = \DB::table('tpoly_workers')->where('id',$lecturer)->get();
                 
        return @$staff;
     
    }
    public function getLecturerFromStaffID($lecturer){
        
        $staff = @\DB::table('tpoly_workers')->where('staffID',$lecturer)->get();
                 
        return @$staff[0]->id;
     
    }

    public function getDepartmentName($deptCode){
        
        $department = \DB::table('tpoly_department')->where('DEPTCODE',$deptCode)->get();
                 
        return @$department[0]->DEPARTMENT;
     
    }
    
    
    public function getSchoolCode($dept){
        
        $school = \DB::table('tpoly_department')->where('DEPTCODE',$dept)->get();
                 
        return @$school[0]->FACCODE;
     
    }
    public function courseSearchByCode() {

        $course = \DB::table('tpoly_courses')->get();
                
         foreach($course as $p=>$value){
             $courses[]=$value->COURSE_CODE;
         }
         return $courses;
    }
    public function programmeSearchByCode() {

        $program = \DB::table('tpoly_programme')->get();
                
         foreach($program as $p=>$value){
             $programs[]=$value->PROGRAMMECODE;
         }
         return $programs;
    }
    public function programmeCategorySearchByCode() {

        $program = \DB::table('tpoly_programme')->get();
                
         foreach($program as $p=>$value){
             $programs[]=$value->SLUG;
         }
         return $programs;
    }
    public function studentSearchByIndexNo($program) {

        $arr = \DB::table('tpoly_students')->where("PROGRAMMECODE",$program)->get();
       //dd($arr);
         foreach($arr as $p=>$value){
             $objects[]=$value->INDEXNO;
         }
         return $objects;
    }
    public function studentSearchByCode($year,$sem,$course,$student) {

        $studentArr= @\DB::table('tpoly_academic_record')->where('year',$year)
        ->where('sem',$sem)
        ->where('course',$course)
        ->where('indexno',$student)
        ->get();

           if(!empty($studentArr)){      
             foreach($studentArr as $p=>$value){
                 $array[]=$value->indexno;
             }
             return @$array;
            }
            else{

            }
    }
    
     public function getSchoolName($dept){
        
        $faculty = \DB::table('tpoly_faculty')->where('FACCODE',$dept)->get();
                 
        return @$faculty[0]->FACULTY;
     
    }
     public function getProgrammeMinCredit($program) {
          $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$program)->get();
                 
        return @$programme[0]->MINCREDITS;
    }
    public function getProgramCode($id){
        
        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$id)->get();
                 
        return @$programme[0]->PROGRAMMECODE;
     
    }
    public function getProgramName($code){
        
        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$code)->get();
                 
        return @$programme[0]->PROGRAMME;
     
    }
      
    
     
    // this is purposely for select box 
    public function getProgramList() {
        if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Accountant"|| @\Auth::user()->department=="Finance" || @\Auth::user()->department=="Planning" || @\Auth::user()->department=="Admissions"){
         $program = \DB::table('tpoly_programme')->orderby("PROGRAMME")
                ->lists('PROGRAMME', 'PROGRAMMECODE');
         return $program;
        }
        elseif( @\Auth::user()->role=='Registrar' ){
         $user_school= @\Auth::user()->department;
              $program = \DB::table('tpoly_programme')->join('tpoly_department','tpoly_department.DEPTCODE', '=', 'tpoly_programme.DEPTCODE')->where('tpoly_department.FACCODE',$user_school)->orderby("tpoly_programme.PROGRAMME")->lists('tpoly_programme.PROGRAMME', 'tpoly_programme.PROGRAMMECODE');
             return $program;
         
         
        }
        else{
              $user_department= @\Auth::user()->department;
              $program = \DB::table('tpoly_programme')->where('DEPTCODE',$user_department)->orderby("PROGRAMME")
                ->lists('PROGRAMME', 'PROGRAMMECODE');
         return $program;
        }
         
    }
     public function totalRegistered($sem,$year,$course,$level,$lecturer) {
if(@\Auth::user()->role=='Lecturer' || @\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Dean'){
        
        $query=Models\AcademicRecordsModel::where('sem',$sem)
                ->where('year',$year)
                ->where('level',$level)

                ->where('lecturer',$lecturer)
                ->where('course',$course)->get();
            }
            else{
                  $query=Models\AcademicRecordsModel::where('sem',$sem)
                ->where('year',$year)
                ->where('level',$level)

                
                ->where('course',$course)->get();
            }
                
        return count($query);
            
    }
    public function years() {

        for ($i = 2008; $i <= 2030; $i++) {
            $year = $i - 1 . "/" . $i;
            $years[$year] = $year;
        }
        return $years;
    }

    // this is purposely for select box 
    public function getCourseList() {
         $course = Models\CourseModel::
                select('COURSE_NAME', 'ID',"PROGRAMME","COURSE_SEMESTER","COURSE_LEVEL","COURSE_CODE")->orderBy("COURSE_NAME")->get();
         return $course;
       
         
    }
    public function getProgramList2() {
         $program= Models\ProgrammeModel::
                select('PROGRAMMECODE', "PROGRAMME")->orderBy("PROGRAMME")->get();
         return $program;
       
         
    }
    
    public function getMountedCourseList() {

          
        $course=@\DB::table('tpoly_mounted_courses')
        ->join('tpoly_courses','tpoly_courses.ID', '=', 'tpoly_mounted_courses.COURSE')->where('tpoly_mounted_courses.Lecturer',@\Auth::user()->staffID )->lists('tpoly_courses.COURSE_NAME', 'tpoly_mounted_courses.ID');
             return $course;
             
         
    }
    // this is purposely for select box 
    public function getLectureList() {
        
         $lecturer = \DB::table('tpoly_workers')->where('designation','Lecturer')
                 ->where('department',$user_department)->orderby("fullName")
                ->lists('fullName', 'id');
         return $lecturer;
       
         
    }
     public function getLectureList_All() {
        
         $lecturer = \DB::table('tpoly_workers')->orderby("fullName")
                 
                ->lists('fullName', 'id');
         return $lecturer;
       
         
    }
     public function getLectureStaffID($id) {
        
         $lecturer = \DB::table('tpoly_workers')->Select("staffID")->where("id",$id)->first();
                 
                
         return $lecturer->staffID;
       
         
    }
     // this is purposely for select box 
    public function getUsers() {
         $user= \DB::table('users')
                ->lists('name', 'id');
         return $user;
       
         
    }
    public function department() {
         $department= \DB::table('tpoly_department')->orderby("DEPARTMENT")
                ->lists('DEPARTMENT', 'DEPTCODE');
         return $department;
       
         
    }
    public function WASSCE_Grades() {
         $grade= \DB::table('tbl_waec_grades_system')
                ->lists('grade', 'grade');
         return $grade;
       
         
    }
    
//     public function firesms($message,$phone,$receipient){
//          
//         
//        
//        //print_r($contacts);
//        if (!empty($phone)&& !empty($message)&& !empty($receipient)) {
//            //$sender = "TPOLY-FEES";
//                 
//                //$key = "83f76e13c92d33e27895";
//                $message = urlencode($message);
//                $phone=$phone; // because most of the numbers came from excel upload
//                 
//                 $phone="+233".\substr($phone,1,9);
//            $url = 'http://txtconnect.co/api/send/'; 
//            $fields = array( 
//            'token' => \urlencode('a166902c2f552bfd59de3914bd9864088cd7ac77'), 
//            'msg' => \urlencode($message), 
//            'from' => \urlencode("TPOLY"), 
//            'to' => \urlencode($phone), 
//            );
//            $fields_string = ""; 
//                    foreach ($fields as $key => $value) { 
//                    $fields_string .= $key . '=' . $value . '&'; 
//                    } 
//                    \rtrim($fields_string, '&'); 
//                    $ch = \curl_init(); 
//                    \curl_setopt($ch, \CURLOPT_URL, $url); 
//                    \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true); 
//                    \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true); 
//                    \curl_setopt($ch, \CURLOPT_POST, count($fields)); 
//                    \curl_setopt($ch, \CURLOPT_POSTFIELDS, $fields_string); 
//                    \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0); 
//                    $result2 = \curl_exec($ch); 
//                    \curl_close($ch); 
//                    $data = \json_decode($result2); 
//                    $output=@$data->error;
//                    if ($output == "0") {
//                   $result="Message was successfully sent"; 
//                   
//                    }else{ 
//                    $result="Message failed to send. Error: " .  $output; 
//                     
//                    } 
//                     
//                
//                $array=  $this->getSemYear();
//                $sem=$array[0]->SEMESTER;
//                $year=$array[0]->YEAR;
//                  $user = \Auth::user()->id;
//                  $sms=new MessagesModel();
//                    $sms->dates=\DB::raw("NOW()");
//                    $sms->message=$message;
//                    $sms->phone=$phone;
//                    $sms->status=$result;
//                    $sms->type="Fees reminder";
//                    $sms->sender=$user;
//                    $sms->term=$sem;
//                    $sms->year=$year;
//                    $sms->receipient=$receipient;
//                     
//                   $sms->save();
//            }
//        
//    }
//    
    public function firesms($message,$phone,$receipient){
          
         
        
        //print_r($contacts);
        if (!empty($phone)&& !empty($message)&& !empty($receipient)) {
             \DB::beginTransaction();
            try {

                 
                //$key = "83f76e13c92d33e27895";
                $message = urlencode($message);
                $phone=$phone; // because most of the numbers came from excel upload
                 
                 $phone="+233".\substr($phone,-9);
            $url = 'http://txtconnect.co/api/send/'; 
            $fields = array( 
            'token' => \urlencode('a166902c2f552bfd59de3914bd9864088cd7ac77'), 
            'msg' => \urlencode($message), 
            'from' => \urlencode("TTU"), 
            'to' => \urlencode($phone), 
            );
            $fields_string = ""; 
                    foreach ($fields as $key => $value) { 
                    $fields_string .= $key . '=' . $value . '&'; 
                    } 
                    \rtrim($fields_string, '&'); 
                    $ch = \curl_init(); 
                    \curl_setopt($ch, \CURLOPT_URL, $url); 
                    \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true); 
                    \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true); 
                    \curl_setopt($ch, \CURLOPT_POST, count($fields)); 
                    \curl_setopt($ch, \CURLOPT_POSTFIELDS, $fields_string); 
                    \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0); 
                    $result2 = \curl_exec($ch); 
                    \curl_close($ch); 
                    $data = \json_decode($result2); 
                    $output=@$data->error;
                    if ($output == "0") {
                   $result="Message was successfully sent"; 
                   
                    }else{ 
                    $result="Message failed to send. Error: " .  $output; 
                     
                    } 
                     
                
                
                  $user = \Auth::user()->id;
                  $sms=new MessagesModel();
                    $sms->dates=\DB::raw("NOW()");
                    $sms->message=$message;
                    $sms->phone=$phone;
                    $sms->status=$result;
                    $sms->type="Form Sales";
                    $sms->sender=$user;
                    $sms->year=date("Y");
                    
                    $sms->receipient=$receipient;
                     
                   $sms->save();
                   \DB::commit();
               } catch (\Exception $e) {
                \DB::rollback();
            }
            }
        
    }
    /**
     * Get current sem and year
     *
     * @param  Request  $request
     * @return Response
     */
    public function getSemYear()
    {
        $sql =\DB::table('tpoly_academic_settings')->where('ID', \DB::raw("(select max(`ID`) from tpoly_academic_settings)"))->get();
        return $sql;
    }
     
    public function getProgram($code){
        
        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$code)->get();
                 
        return @$programme[0]->PROGRAMME;
     
    }
    public function getStudentPassword($user){
        
        $userArr = \DB::table('tpoly_log_portal')->where('username',$user)->get();
                 
        return @$userArr[0]->real_password;
     
    }
    public function getProgramArray($code){
        
        $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$code)->get();
                 
        return @$programme;
     
    }
     public function getStudentByID($id){
        
        $student = \DB::table('tpoly_students')->where('ID',$id)->get();
                 
        return @$student[0]->INDEXNO;
     
    }
    public function getStudentIDfromIndexno($indexno) {
        $student = \DB::table('tpoly_students')->where('INDEXNO',$indexno)->get();
                 
        return  @$student[0]->ID;
    }
    public function getStudentNameByID($id){
        
        $student = \DB::table('tpoly_students')->where('ID',$id)->get();
                 
        return @$student[0]->NAME;
     
    }
     public function getStudent($indexNo){
        
        $student = \DB::table('tpoly_students')->where('INDEXNO',$indexNo)->get();
                 
        return @$student;
     
    }
     public function getStudentsTotalPerProgramLevel($program,$level){
         $array = $this->getSemYear();

        $year = $array[0]->YEAR;
//         $total = \DB::select( \DB::raw(" s.level,s.year,s.PROGRAMMECODE,s.indexno,a.student FROM `tpoly_students` as s JOIN tpoly_academic_record as a on s.id=a.student WHERE s.PROGRAMMECODE='$program'and "
//                 . ""
//                 . "a.level='$level' and a.year='$year'
//        )"))->groupBy("a.student")
//                 ->get();
//         dd($total);
         
          $total = \DB::table('tpoly_students')->leftJoin('tpoly_academic_record', 'tpoly_students.ID', '=', 'tpoly_academic_record.student')
                     
                     ->where('tpoly_students.PROGRAMMECODE', $program)
                     ->where('tpoly_academic_record.level', $level)
                     ->where('tpoly_academic_record.year', $year)
                     ->groupBy('tpoly_academic_record.student')
                     ->count();
               return $total;
    }
     public function getStudentsTotalPerProgram($program,$level=NULL){
        if($level==NULL){
        $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)
                 ->where("STATUS","In School")->where("SYSUPDATE","1")
                ->count();
        return $total;
        }
        else{
            $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)
                 ->where("year",$level)->where("STATUS","In School")->where("SYSUPDATE","1")
                 
                ->count();
        return $total;
        }
        
     
    }
      public function getStudentsTotalPerProgram2($level){
         
        $total = \DB::table('tpoly_students')->where('LEVEL',$level)
                ->where("SYSUPDATE","1")->where("STATUS","In School")
                ->count();
        return $total;
        
         
     
    }
     public function getTotalStudentsByProgramCount($program,$level){
         $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $total= \DB::table('tpoly_students')
               ->join('tpoly_feedetails', 'tpoly_feedetails.INDEXNO', '=', 'tpoly_students.INDEXNO')
            
               ->where('tpoly_students.PROGRAMMECODE',$program)
                   ->where('tpoly_feedetails.LEVEL',$level)
                 ->where('tpoly_feedetails.YEAR',$year)
            ->count("tpoly_feedetails.ID");
 
      return @$total;
        
    }
    public function getTotalPaymentByProgram($program,$level){
         $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $amount= \DB::table('tpoly_students')
               ->join('tpoly_feedetails', 'tpoly_feedetails.INDEXNO', '=', 'tpoly_students.INDEXNO')
            
               ->where('tpoly_students.PROGRAMMECODE',$program)
                   ->where('tpoly_feedetails.LEVEL',$level)
                 ->where('tpoly_feedetails.YEAR',$year)
            ->sum("tpoly_feedetails.AMOUNT");
 
      return @$amount;
        
    }
     public function getTotalRegistered($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.REGISTERED',1)
            ->count("tpoly_students.ID");
 
      return @$total;
        
    }
     public function getTotalOwingbyProgram($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.STATUS','In School')
            ->sum("tpoly_students.BILL_OWING");
 
      return @$total;
        
    }
    public function getTotalStudentOwing($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.STATUS','In School')
            ->where("tpoly_students.BILL_OWING",">",0)
            ->count("tpoly_students.ID");
      return @$total;
        
    }
     public function getTotalBillForProgram($program,$level ){
          $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $amount= \DB::table('tpoly_bills')
                   ->where('tpoly_bills.PROGRAMME',$program)
                    ->where('tpoly_bills.LEVEL',$level)
                 ->where('tpoly_bills.YEAR',$year)
            ->first();
 
      return @$amount->AMOUNT;
        
    }
     public function getStaffAccount($id){
        
        $staff = \DB::table('tpoly_workers')->where('staffID',$id)->get();
                 
        return $staff;
     
    }
    public function getProgramCodeByID($id){
        
        $programme = \DB::table('tpoly_programme')->where('ID',$id)->get();
                 
        return @$programme[0]->PROGRAMMECODE;
     
    }
    // return course array based on code
    public function getCourseByCodeObject($id) {
        $mount = \DB::table('tpoly_mounted_courses')->where('ID',$id)->first();
         
         $course = \DB::table('tpoly_courses')->where('ID',$mount->COURSE)->get();
                 
        return @$course;
    }
     public function getCourseByCode($code) {
         $course = \DB::table('tpoly_courses')->where('COURSE_CODE',$code)->get();
                 
        return @$course[0]->ID;
    }
    public function getCourseByCode2($code,$program) {
         $course = \DB::table('tpoly_courses')->where('COURSE_CODE',$code)
                 ->where("PROGRAMME",$program)
                 ->get();
                 
        return @$course[0]->ID;
    }
    public function getProgramByID($id) {
         $programme = \DB::table('tpoly_programme')->where('ID',$id)->get();
                 
        return @$programme[0]->PROGRAMME;
    }
     public function getProgramByGradeSystem($program) {
         $programme = \DB::table('tpoly_programme')->where('PROGRAMMECODE',$program)->get();
                 
        return @$programme[0]->GRADING_SYSTEM;
    }
    public function getCourseProgrammeMounted($course) {
        
         $programme= \DB::table('tpoly_mounted_courses')->where('ID',$course)->get();
                 
        return @$programme[0]->PROGRAMME;
    }
    public function getCourseProgramme($course) {
        
         $programme= \DB::table('tpoly_courses')->where('ID',$course)->get();
                 
        return @$programme[0]->PROGRAMME;
    }
    public function getGrade($mark,$type){
        
        $grade = \DB::table('tpoly_grade_system')->where('lower','<=',$mark)
                ->where('lower','<=',$mark)
                ->where('upper','>=',$mark)
                ->where('type',$type)
                ->get();
                 
        return $grade;
     
    }
     
     
     public function getCourseCodeByID($id){
         
         $course= \DB::table('tpoly_academic_record')
            ->join('tpoly_mounted_courses', 'tpoly_academic_record.course', '=', 'tpoly_mounted_courses.ID')
            ->join('tpoly_courses', 'tpoly_mounted_courses.COURSE', '=', 'tpoly_courses.ID')
            ->select('tpoly_courses.COURSE_CODE')->where('tpoly_academic_record.course',$id)
            ->get();
 
      return @$course[0]->COURSE_CODE;
   
    }
    
    public function getCourseCodeByIDArray($id){
         
         $course= \DB::table('tpoly_courses')->where('ID',$id)
              ->get();
 
      return @$course;
   
    }
    public function getCourseMountedInfo($id){
         
         $course= \DB::table('tpoly_mounted_courses')->where('ID',$id)
              ->get();
 
      return @$course;
   
    }
    
    
    public function getCourseByIDCode($code){
         
          $course= \DB::table('tpoly_academic_record')
            ->leftjoin('tpoly_mounted_courses', 'tpoly_academic_record.course', '=', 'tpoly_mounted_courses.ID')
            ->leftjoin('tpoly_courses', 'tpoly_mounted_courses.COURSE', '=', 'tpoly_courses.ID')
            ->select('tpoly_academic_record.course')->where('tpoly_courses.COURSE_CODE',$code)
            ->get();
 
      return @$course[0]->course;
   
    }
     public function getCourseByID($id){
        
        $course = \DB::table('tpoly_courses')->where('COURSE_CODE',$id)->get();
                 
        return @$course[0]->COURSE_NAME;
     
    }
     public function getCourse($id){
        
        $course = \DB::table('tpoly_courses')->where('ID',$id)->get();
                 
        return @$course[0]->COURSE_NAME;
     
    }
     public function getTotalFeeByProrammeLevel($program,$level){
       $program=  $this->getProgramCodeByID($program);
        $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)->where('YEAR',$level)->where('STATUS','=','In school')->COUNT('*');
                // dd($total);
        return @$total;
     
    }
   public function picture($path,$target){
                if(file_exists($path)){
                        $mypic = getimagesize($path);

                 $width=$mypic[0];
                        $height=$mypic[1];

                if ($width > $height) {
                $percentage = ($target / $width);
                } else {
                $percentage = ($target / $height);
                }

                //gets the new value and applies the percentage, then rounds the value
                 $width = round($width * $percentage);
                $height = round($height * $percentage);

               return "width=\"$width\" height=\"$height\"";



            }else{}
        
       
        }
        
        
	public function pictureid($stuid) {

        return str_replace('/', '', $stuid);
    }
     
    function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
    }
    public function formatCurrency($amount) {
       return number_format($amount,3);
            
    }
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
