<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Date Calculator</title>
        
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <style>
            #result {
                background-color: #eee;
                margin-top: 10px;
                padding: 5px 0;
                text-align: center;
                display: none;
            }

            #error {
                display: none;
            } 
            
            #calculate-btn {
                margin-top: 32px;
            }

            @media (max-width:575px) {
                #calculate-btn {
                    margin-top: 0;
                }
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Date Calculator</a>
        </nav>

        <main role="main" class="container d-flex justify-content-center" style="margin-top:20vh;">
            <div class="row">
                <div class="col-sm-12"> 
                    <div class="alert alert-danger col-12" id="error" role="alert"></div>  

                    <div class="row">                   
                        <div class="col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="text" v-model="start_date" class="datepicker form-control" id="start_date" name="start_date" placeholder="dd/mm/yyyy" data-inputmask="'alias': 'date'">
                            </div>
                        </div>
                        <div  class="col-sm-4 col-xs-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="text" v-model="end_date" class="datepicker form-control" id="end_date" name="end_date" placeholder="dd/mm/yyyy" data-inputmask="'alias': 'date'">
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <button class="btn btn-primary w-100" id="calculate-btn" onClick="onCalculatePressed()">CALCULATE</button>
                        </div>
                    </div>
                    
                    <div class="col-sm-12" id="result"></div>  
                </div> 
            </div>
        </main>
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
        <script>
            $(".datepicker").inputmask();
            $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });

            function onCalculatePressed() {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val(); 

                if (!validFields(start_date, end_date)) {
                    return;
                }

                start_date = formatForBackend($('#start_date').val());
                end_date = formatForBackend($('#end_date').val());                

                var url = "/" + start_date + "/" + end_date;

                $.get(url, function (data) {
                    var result_html =  $('#result');
                    result_html.html(data + " days");
                    result_html.show();
                });
            }

            function formatForBackend(date) {
                date_arr = date.split('/');
                return date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0];
            }

            function validFields(start_date, end_date) {
                var error_html = $('#error');
                error_html.hide();
                error_html.html("");

                var no_error = true;

                console.log(start_date.length);
                console.log(start_date);

                if (start_date.length != 10|| start_date.includes('d') || start_date.includes('m') || start_date.includes('y')) {
                    error_html.show();
                    error_html.append("<div>Start Date is required.</div>");
                    no_error = false;
                } 

                if (end_date.length != 10 || end_date.includes('d') || end_date.includes('m') || end_date.includes('y')) {
                    error_html.show();
                    error_html.append("<div>End Date is required.</div>");
                    no_error = false;
                } 

                if (no_error) {
                    error_html.hide();
                }

                return no_error;
            }
        </script>
    </body>
</html>
