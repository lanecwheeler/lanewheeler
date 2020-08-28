<html>
    <head>
        <style>
            body {
                margin: 0;
                background: black;
                display: flex;
                justify-content: center;
            }

            .logs {
                background: white;
                margin: 1em;
                border: 1px solid red;
                max-width: 500px;
            }

            .logs td {
                font-family: "Bebas Neue", "sans-serif";
                padding: .25em;
                max-height: 150px;
                overflow: auto;
            }
        </style>
    </head>
    <body>
        <table class="logs">
            <thead>
                <tr>
                    <th>id</th>
                    <th>page</th>
                    <th>error_code</th>
                    <th>error_message</th>
                    <th>request</th>
                    <th>ip</th>
                    <th>crated at</th>
                    <th>updated at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{$log->id}}</td>
                        <td>{{$log->page}}</td>
                        <td>{{$log->error_code}}</td>
                        <td>{{$log->error_message}}</td>
                        <td>{{$log->request}}</td>
                        <td>{{$log->ip}}</td>
                        <td>{{$log->crated_at}}</td>
                        <td>{{$log->updated_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>