<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to RMP</title>
        <link href="/css/app2.css" rel="stylesheet">
    </head>

    <body>
        @if($errors->all())
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        @endif
        
        <form action="/downloads" method="post" id="download_form">
            {{ csrf_field() }}

            <div class="header">
                <!-- <div><img src="/images/logo.png" alt="RMP Logo" title="RMP logo" width="100%"></div> -->
                @if (session('alert'))
                    <div class="alert alert-warning">
                        {{ session('alert') }}
                    </div>
                @endif
                <div style='margin: 10px; text-align: left'>
                    <input type="button" value="Select All" id="select_all" />
                    <input type="submit" value="Download" id="submit" />
                </div>
            </div>

            <div style='margin: 10px; text-align: center;'>
                <table class="student-table">
                    <tr>
                        <th>Filename</th>
                        <th>Created</th>
                        <th>Download</th>
                    </tr>

                    @if( count($downloads) > 0 )
                    @foreach($downloads as $download)
                    <tr>
                        <td>{{ $download['download_name'] }}</td>
                        <td>{{ $download['created_at'] }}</td>
                        <td><a href="{{ route('export-downloadlog-item', $download['id']) }}">Download</a></td>
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

          });
        </script>
    </body>

</html>
