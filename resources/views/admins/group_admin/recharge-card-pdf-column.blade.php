<table style="color:black;border: 1px solid black;">

    <tr>
        <th style="border-bottom: 1px solid black;font-size: 12px;">{{ $package->name }}</th>
    </tr>

    <tbody>

        <tr>
            @if ($master_package->volume_limit)
            <td style="text-align:left; border-bottom: 1px solid black;">
                <span style="font-style: italic;font-size: 11px;">
                    Data Limit: {{ $master_package->volume_limit }} {{ $master_package->volume_unit }}
                </span>
            </td>
            @else
            <td style="text-align:left; border-bottom: 1px solid black;">
                <span style="font-style: italic;font-size: 11px;">
                    Data Limit: Unlimited
                </span>
            </td>
            @endif
        </tr>

        <tr>
            <td style="text-align:left; border-bottom: 1px solid black;">
                <span style="font-style: italic;font-size: 16px;">
                    PIN: {{ $card->pin }}
                </span>
            </td>
        </tr>

        <tr>
            <td style="text-align:left; border-bottom: 1px solid black;">
                <span style="font-style: italic;font-size: 12px;">
                    Powered by: <br>
                    {{ $user->company }}
                </span>
            </td>
        </tr>

        <tr>
            <td style="text-align:left;">
                <span style="font-style: italic;font-size: 11px;">
                    Helpline: {{ $user->helpline }}
                </span>
            </td>
        </tr>

    </tbody>

</table>
<!--/table -->
