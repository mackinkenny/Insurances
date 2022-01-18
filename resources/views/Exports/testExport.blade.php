<h2>Report from {{$from }} to {{$to}}</h2>
<p> </p>
<table>
    <thead>
    <tr>
        <th style="border: 2px solid black; font-weight: bold; font-size: 12px;">Policy Number</th>
        <th style="border: 2px solid black; font-weight: bold; font-size: 12px;">Start Date</th>
    </tr>
    </thead>
    <tbody>

    @foreach($contracts as $key => $contract)
        <tr>
            <td style="text-align: left;">
                @if($contract->policy_number != null)
                    {{ $contract->policy_number }}
                @endif
            </td>
            <td style="text-align: left;">
                @if($contract->start_date != null)
                    {{ $contract->start_date }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
