

    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>ID</th><th>Daytype Id</th><th>Datum</th><th>Note</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($data['list'] as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->daytype_id }}</td><td>{{ $item->datum }}</td><td>{{ $item->note }}</td>
                    <td>
        @include('crudbase.listbuttons')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
      
    </div>


