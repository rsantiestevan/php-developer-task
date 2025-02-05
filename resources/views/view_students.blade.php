<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>

        <form action="/export" method="post" id="student_form">
            {{ csrf_field() }}

            <div class="header">
                <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div>
                @if (session('alert'))
                    <div class="alert alert-warning">
                        {{ session('alert') }}
                    </div>
                @endif
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

                    @if(  count($students) > 0 )
                    @foreach($students as $student)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="studentId[]" value="{{ $student['id'] }}"></td>
                        <td>{{ $student['firstname'] }}</td>
                        <td>{{ $student['surname'] }}</td>
                        <td>{{ $student['email'] }}</td>
                        <td>{{ $student['course']['university'] }}</td>
                        <td>{{ $student['course']['course_name'] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" style="text-align: center">Oh dear, no data found.</td>
                    </tr>
                    @endif
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
