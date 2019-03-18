<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>

        <form action="/export" method="post" id="student_form">
            <?php echo e(csrf_field()); ?>


            <div class="header">
                <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>
                <?php if(session('alert')): ?>
                    <div class="alert alert-warning">
                        <?php echo e(session('alert')); ?>

                    </div>
                <?php endif; ?>
                <div style='margin: 10px; text-align: left'>
                    <input type="hidden" id="filename" name="filename" value="">
                    <input type="button" value="Select All" id="select_all" />
                    <input type="submit" value="Export" id="submit" />
                </div>
            </div>

            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th></th>
                        <th>Forename</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>University</th>
                        <th>Course</th>
                    </tr>

                    <?php if(  count($students) > 0 ): ?>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="studentId[]" value="<?php echo e($student['id']); ?>"></td>
                        <td><?php echo e($student['firstname']); ?></td>
                        <td><?php echo e($student['surname']); ?></td>
                        <td><?php echo e($student['email']); ?></td>
                        <td><?php echo e($student['course']['university']); ?></td>
                        <td><?php echo e($student['course']['course_name']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>
          $(document).ready(function() {

            var allChecked = false;

            $("#select_all").click(function(event){
                event.preventDefault();
                allChecked = !allChecked;
                $(".checkbox").prop('checked', allChecked);
                setSelectAllLabel(allChecked);
            });

            $('.checkbox').change(function(){
                if(false == $(this).prop("checked")){
                    allChecked = false;
                }
                if ($('.checkbox:checked').length == $('.checkbox').length ){
                    allChecked = true;
                }
                setSelectAllLabel(allChecked);
            });

            function setSelectAllLabel(allChecked) {
                if (allChecked) {
                    $("#select_all").prop("value", "Unselect All");
                } else {
                    $("#select_all").prop("value", "Select All");
                }
            }
            
            $("#submit").click(function(e){
                if($('.checkbox:checked').length == 0){
                    e.preventDefault();
                }else{
                    var fileName = prompt("Please enter the name for your csv file", "");
                    if (fileName != '') {
                        document.getElementById("filename").value = fileName;
                    }
                }
            });
            

          });
        </script>
    </body>

</html>
