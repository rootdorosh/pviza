@if (!empty($items))
<table class="table-job-listing table-responsive">
    @foreach ($items as $item)
    <tr>
        <td class="table-job-listing-main">
            <!-- Company Minimal-->
            [ <?= $item->id?> ]
            <article class="company-minimal">
                <div class="company-minimal-main">
                    <h5 class="company-minimal-title"><a href="{{ d_l('/jobs/' . $item->alias) }}">{{ $item->title }}</a></h5>
                    @if (!empty($item->hiring_organization))
                    <span class="hiringorganization">{{ $item->hiring_organization }}</span><br/>
                    @endif
                    @if (!empty($item->contract_type))
                    <span class="sallary">{{ t('contract-type') }} {{ $item->contract_type }}</span><br/>
                    @endif
                    @if (!empty($item->salary))
                    <span class="sallary">{{ t('salary') }} {{ $item->salary }}</span><br/>
                    @endif
                    @if (!empty($item->work_schedule))
                    <span class="sallary">{{ t('work-schedule') }} {{ $item->work_schedule }}</span><br/>
                    @endif
                    @if (!empty($item->types))
                    {!! implode(' ', array_map(function($value) { return '<span class="badge badge-secondary text-lower">'.trim($value).'</span>'; }, explode(',', $item->types)))  !!}<br/>
                    @endif
                    @if (!empty($item->categories))
                    {!! implode(' ', array_map(function($value) { return '<span class="badge badge-tertiary text-lower">'.trim($value).'</span>'; }, explode(',', $item->categories)))  !!}<br/>
                    @endif
                </div>
            </article>
        </td>
        <td class="table-job-listing-2-location">
            <div class="object-inline"><span class="icon icon-2 text-primary mdi mdi-map-marker"></span>
                <span class="joblocation">{{ $item->locations }}  </span><br/>
                <span class="dateposted">{{ $item->date_posted }}</span>

            </div>
        </td>
    </tr>
    @endforeach
</table>

<nav class="pagination-outer text-center">
    {!! (new \App\Services\Pager(['limit' => $limit, 'count' => $count]))->run() !!}
</nav>
@else
    <p>{{ t('vacancy.list.empty') }}</p>
@endif
