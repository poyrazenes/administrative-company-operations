<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <div class="row align-items-start">
        <div class="offset-3 col-6 mt-5">
            @if(session()->has('form_result_messages'))
                <div class="alert alert-dismissible alert-{{ session()->get('form_result_alert_type') }} px-3 py-4">
                    @if(session()->has('form_result_alert_title') && !empty(session()->get('form_result_alert_title')))
                        <h4>{{ session()->get('form_result_alert_title') }}</h4>
                    @endif
                    <ul class="m-2">
                        @foreach(session()->get('form_result_messages') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger">
                    <h4>Fail!</h4>
                    <ul>
                        @foreach($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
            @endif

            <h2>Administrative Company Operations</h2>
            <form method="POST" action="{{ action('AdministrativeCompanyOperationsController@addNewOperation') }}">
                @csrf
                <div class="form-outline mb-4">
                    <label class="form-label" for="company_administrative_operation_type">Type</label>
                    <select class="form-select" aria-label="Default select example" id="company_administrative_operation_type" name="type">
                        <option selected value="destroy_source_codes">Destroy Source Code</option>
                    </select>
                </div>
                <div class="form-outline mb-4">
                    <label class="form-label" for="company_administrative_operation_value">Value</label>
                    <input type="text" id="company_administrative_operation_value" class="form-control" name="value" placeholder="Yes, No, True, False, vs."/>
                </div>
                <button type="submit" class="btn btn-primary btn-block mb-4">Submit</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
