<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ config('website.name') }}</title>
    @php
    $template_master = $master->getTable();
    $template_detail = $template_master.'_detail';
    $date = $master->{$template_master.'_date'};
    $total = 0;
    @endphp
    @include(Helper::setViewEmail('order_css_order', 'sales'))
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ Helper::files('logo/'.config('website.logo')) }}"
                                    style="width:100%; max-width:300px;">
                            </td>

                            <td>
                                Purchase Order #: {{ $master->{$master->getKeyName} }}<br>
                                Created: {{ $date->toFormattedDateString() }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{ $customer->crm_customer_name ?? '' }}.<br>
                                {{ $customer->crm_customer_description ?? '' }}
                            </td>

                            <td>
                                {{ config('website.name') }}.<br>
                                {{ config('website.owner') }}<br>
                                {{ config('website.address') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Qty
                </td>

                <td>
                    Price
                </td>

                <td>
                    Total
                </td>
            </tr>
            @foreach ($detail as $item)
            <tr class="item">
                <td>
                    {{ $item->product->item_product_name }}
                </td>

                <td>
                    {{ $item->{$template_detail.'_qty_order'} }}
                </td>

                <td>
                    {{ number_format($item->{$template_detail.'_price_order'}) }}
                </td>

                <td>
                    {{ number_format($item->{$template_detail.'_total_order'}) }}
                </td>
            </tr>
            @endforeach

            <tr class="item last">
                <td colspan="3">
                    Total
                </td>

                <td>
                    {{ number_format($detail->sum($template_detail.'_total_order')) }}
                </td>
            </tr>

        </table>
    </div>
</body>

</html>