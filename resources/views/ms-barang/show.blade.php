        <table class="table table-sm table-bordered table-stripped">
            <tbody>
                <tr>
                    <th width="30%">Name</th>
                    <td>{{ $record->name }}</td>
                </tr>
                <tr>
                    <th width="30%">Description</th>
                    <td>{{ $record->description }}</td>
                </tr>
                <tr>
                    <th width="30%">Is Active</th>
                    <td>{{ $record->is_active }}</td>
                </tr>
            </tbody>
        </table>
